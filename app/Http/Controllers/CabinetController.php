<?php

namespace App\Http\Controllers;

use App\Models\ProfileReferrer;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        // Перевірка чи підтверджено відео, якщо так то відкриється блок з вибором програм
        $user_id = Auth::id();

        $blockForm = Video::where('user_id', $user_id)
            ->where(function ($query) {
                $query->whereNull('is_program')->orWhere('is_program', 0);
            })
            ->first();

        $selectVideo = Video::where('user_id', $user_id)
            ->where('is_approved', null)
            ->first();

        $video = Video::where('user_id', $user_id)
            ->where('is_approved', 1)
            ->where(function ($query) {
                $query->whereNull('is_program')->orWhere('is_program', 0);
            })
            ->first();

        // Вивід балансу на сторінку
        $balance = Purse::where('user_id', $user_id)
            ->where('wallet_type', 1)
            ->first();

        // Яка програма відкрита
        $program = ProgramsUser::where('user_id', $user_id)
            ->whereNull('payment_program')
            ->first();

//        // Виклик методу для отримання всіх рефералів користувача та їхніх рефералів
//        $referals = $this->getAllReferralsRecursive($user_id);
//        \Log::info('$referals', $referals);


        return view('cabinet', [
            'video' => $video,
            'balance' => $balance,
            'blockForm' => $blockForm,
            'selectVideo' => $selectVideo,
            'program' => $program->program_id ?? null,
//            'referrals' => $referals,
        ]);
    }

//    /**
//     * Отримання всіх рефералів користувача та їхніх рефералів.
//     *
//     * @param  int  $userId
//     * @return \Illuminate\Http\Response
//     */
//    public function getReferrals($userId)
//    {
//        // Починаємо з користувача з вказаним ID
//        $referrals = $this->getReferralsRecursive($userId);
//
//        return $referrals;
//    }
//
//// Рекурсивний метод для отримання всіх рефералів користувача та їхніх рефералів
//    private function getReferralsRecursive($userId, &$referrals = [])
//    {
//        // Отримуємо всіх рефералів поточного користувача
////        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
//        $directReferrals = ProfileReferrer::where('referrer_id', $userId)->pluck('user_id')->toArray();
//
//        // Додаємо всіх прямих рефералів до загального списку рефералів
//        $referrals = array_merge($referrals, $directReferrals);
//
//        // Рекурсивно обходимо кожного реферала та шукаємо їх рефералів
//        foreach ($directReferrals as $referralId) {
//            $this->getReferralsRecursive($referralId, $referrals);
//        }
//
//        return $referrals;
//    }











    private function getAllReferralsRecursive($userId, &$referrals = []) {
        // Отримати прямих рефералів поточного користувача
//        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
        $directReferrals = ProfileReferrer::where('referrer_id', $userId)->pluck('user_id')->toArray();

        \Log::info('$directReferrals', $directReferrals);

        // Додати прямих рефералів до загального списку рефералів
        $referrals = array_merge($referrals, $directReferrals);

        // Рекурсивно отримати всіх рефералів для кожного прямого реферала
        foreach ($directReferrals as $referralId) {
            // Перевірка чи є користувач амбасадором
            $isUserAmbassador = User::where('id', $referralId)
                ->where('is_ambassador', 1)
                ->exists();

            if (!$isUserAmbassador) {
                // Рекурсивно отримати всіх рефералів для кожного прямого реферала, які не є амбасадорами
                $this->getAllReferralsRecursive($referralId, $referrals);
            }
        }

        return $referrals;
    }








//    private function getReferralsRecursive($userId, &$referrals = [], $level = 1)
//    {
//        // Перевірка чи є користувач амбасадором
//        $isUserAmbassador = User::where('id', $userId)
//            ->where('is_ambassador', 1)
//            ->first();
//
//        if (!$isUserAmbassador) {
//            // Виводити тільки 3 лінії рефералів
//            if ($level > 3) {
//                return [];
//            }
//
//            // Отримати прямих рефералів поточного користувача
////            $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
//            $directReferrals = ProfileReferrer::where('referrer_id', $userId)->pluck('user_id')->toArray();
//            \Log::info('Масив прямих рефералів', $directReferrals);
//
//            // Рекурсивно отримати рефералів для кожного прямого реферала
//            foreach ($directReferrals as $referralId) {
//
//                // Додати прямого реферала з відповідним рівнем
//                $referrals[] = ['user_id' => $referralId, 'level' => $level];
//
//                // Рекурсивно отримати рефералів для кожного прямого реферала, які не є амбасадорами
//                $this->getReferralsRecursive($referralId, $referrals, $level + 1);
//            }
//
//            // Впорядкувати масив за рівнем
//            usort($referrals, function ($a, $b) {
//                return $a['level'] <=> $b['level'];
//            });
//
//            return $referrals;
//        }
//    }
}
