<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'birthday',
        'referrer_hash',
        'twofa_secret',
        'avatar',
        'verification_withdrawal',
        'verification_tariff_closing',
        'role_id',
        'achived_turnover',
        'is_ambassador',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function referrerData( $user_id )
    {
        return ProfileReferrer::where('profile_referrers.user_id', $user_id)
            ->join('users', 'profile_referrers.referrer_id', '=', 'users.id')
            ->first();
    }

    public static function getRefferrarTreeWay($id) {
        $way = [];
        $userParentData = ProfileReferrer::where('user_id', $id)->first();
        if (!empty($userParentData)) {
            do {
                if (empty($userParentData)) break;
                $UserParent = User::where('id', $userParentData->referrer_id)->first();
                $way[] = $UserParent['id'];
                $userParentData = ProfileReferrer::where('user_id', $UserParent['id'])->first();
            } while(!empty($UserParent) || $UserParent->id !== Auth::user()->id);
        }
        foreach ($way as $key => $item) {
            if ($item === Auth::user()->id) {
                unset($way[$key]);
            }
        }
        return array_reverse($way);
    }

    public function allRefferralsIds( $refferral, &$ids = [], $mainId = 0, $include_ambassador = true, $ambassadorDate = null )
    {
        $id = !empty(Auth()->user()) ? Auth()->user()->id : $mainId;
        if (($refferral->id ?? 0) != $id ) {
            $ids[] =  $refferral->id ?? 0;
        }
        $refferralListSql = ProfileReferrer::where('referrer_id', ($refferral->id ?? 0));
        if (!empty($ambassadorDate)) {
            $refferralListSql->whereDate('created_at', '<', $ambassadorDate);
        }
        $refferralList = $refferralListSql->get()->toArray();
        foreach( $refferralList as $child ) {
            $user = User::where('id', $child['user_id'])->first();
            if (($user->is_ambassador ?? 0) && !$include_ambassador && empty($user->ambassador_date)) {
                $ids[] = $user->id ?? 0;
                continue;
            }
            $this->allRefferralsIds( $user, $ids, 0, $include_ambassador, $user->ambassador_date ?? null );
        }
    }

    /**
     *
     */

    public function partnersRefferrals(int $user_id = 0, $page = 1, $limit = 100)
    {
        $result = collect(User::select(DB::raw('SUM(deposits.amount) AS depositsAmount'), 'users2.*', DB::raw('GROUP_CONCAT(profile_referrers.referrer_id) as referrer_id'))
            ->join('profile_referrers', 'profile_referrers.referrer_id', '=', 'users.id')
            ->join('users as users2', 'profile_referrers.user_id', '=', 'users2.id')
            ->leftJoin('deposits', 'deposits.user_id', '=', 'users2.id')
            ->where('users.id', $user_id)
            ->orderBy('users2.id', 'desc')
            ->groupBy('users2.id')
            ->offset(($page - 1) * 10)
            ->limit($limit)
            ->get())->keyBy('id');

        foreach ($result as $item) {
            $userIds = $this->findUserIdsByReferrerId($item['id']);

            // Перевіряємо, чи $userIds є пустим масивом
            $hasReferrers = !empty($userIds);

            // Додаємо поле "hasReferrers" до моделі
            $item->hasReferrers = $hasReferrers;

            $user = User::find($item['id']);
            $refferralIdList = [];
            $this->allRefferralsIds( $user, $refferralIdList );
            $refferralIdList = array_filter($refferralIdList, function ($value) use ($user) {
                return $value !== 0 && $value !== $user->id;
            });
            $item->countReferrers = count($refferralIdList);
            $turnoverAllPartners = Deposit::select(DB::raw('SUM(amount) as total_profit'))
                ->whereIn('user_id', array_values(array_filter($refferralIdList)))->first();
            $item->turnoverAllPartners  =  $turnoverAllPartners['total_profit'] ?? 0;
        }


        // Ключуються моделі за полем "id" і повертаються як колекція
        return $result;

    }
    public function findUserIdsByReferrerId($referrerId)
    {
        $results = DB::table('profile_referrers')
            ->select('user_id')
            ->where('referrer_id', $referrerId)
            ->get();

        $userIds = $results->pluck('user_id')->toArray();

        return $userIds;
    }

    public function myUserInfo($user_id)
    {
        // Получаем ID текущего авторизованного пользователя
        $result = User::select(DB::raw('SUM(deposits.amount) AS depositsAmount'), 'users.id', 'users.first_name', 'users.last_name', 'users.messenger', 'users.email', 'users.email_verified_at', DB::raw('GROUP_CONCAT(profile_referrers.referrer_id) as referrer_id'))
            ->leftJoin('profile_referrers', 'profile_referrers.referrer_id', '=', 'users.id')
            ->leftJoin('deposits', 'deposits.user_id', '=', 'users.id')
            ->where('users.id', $user_id)
            ->groupBy('users.id','users.first_name', 'users.last_name', 'users.messenger', 'users.email', 'users.email_verified_at')
            ->first();
        $user = User::find($user_id);
        $refferralIdList = [];
        $this->allRefferralsIds( $user, $refferralIdList );
        $refferralIdList = array_filter($refferralIdList, function ($value) use ($user) {
            return $value !== 0 && $value !== $user->id;
        });
        $result->countReferrers = count($refferralIdList);
        $turnoverAllPartners = Deposit::select(DB::raw('SUM(amount) as total_profit'))
            ->whereIn('user_id', array_values(array_filter($refferralIdList)))->first();
        $result->turnoverAllPartners  =  $turnoverAllPartners['total_profit'] ?? 0;
        return $result;
    }

    public function getReferralsTree($user_id, $page = 1, $limit = 100)
    {
        return $this->buildReferralTree($user_id);
    }

    private function buildReferralTree($user_id, $depth = 1, $maxDepth = 11)
    {
        if ($depth >= $maxDepth) {
            return null; // Если достигнута максимальная глубина, возвращаем null
        }

        $referrals = $this->getReferrals($user_id);

        $result = [];

        foreach ($referrals as $referral) {
            $referral->level = $depth; // Добавляем уровень к рефералу
            $result["node" . $referral->id] = $referral; // Используем id в качестве индекса

            $referral->children = $this->buildReferralTree($referral->id, $depth + 1, $maxDepth);
        }

        return $result;
    }

    public function getReferrals($user_id, $page = 1, $limit = 100)
    {
        $result = User::select(DB::raw('SUM(deposits.amount) AS depositsAmount'), 'users2.*', DB::raw('GROUP_CONCAT(profile_referrers.referrer_id) as referrer_id'))
            ->join('profile_referrers', 'profile_referrers.referrer_id', '=', 'users.id')
            ->join('users as users2', 'profile_referrers.user_id', '=', 'users2.id')
            ->leftJoin('deposits', 'deposits.user_id', '=', 'users2.id')
            ->where('users.id', $user_id)
            ->orderBy('users2.id', 'desc')
            ->groupBy('users2.id')
            ->get()
            ->keyBy('id');

        foreach ($result as $item) {
            $userIds = $this->findUserIdsByReferrerId($item['id']);

            // Перевіряємо, чи $userIds є пустим масивом
            $hasReferrers = !empty($userIds);

            // Додаємо поле "hasReferrers" до моделі
            $item->hasReferrers = $hasReferrers;
            $user = User::find($item['id']);
            $refferralIdList = [];
            $this->allRefferralsIds( $user, $refferralIdList );
            $refferralIdList = array_filter($refferralIdList, function ($value) use ($user) {
                return $value !== 0 && $value !== $user->id;
            });
            $item->countReferrers = count($refferralIdList);
            $turnoverAllPartners = Deposit::select(DB::raw('SUM(amount) as total_profit'))
                ->whereIn('user_id', array_values(array_filter($refferralIdList)))->first();
            $item->turnoverAllPartners  =  $turnoverAllPartners['total_profit'] ?? 0;
        }

        return $result;
    }

}
