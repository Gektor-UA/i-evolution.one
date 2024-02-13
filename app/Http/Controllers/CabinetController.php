<?php

namespace App\Http\Controllers;

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

//        // Виклик методу для отримання всіх рефералів користувача та їхніх рефералів
//        $referals = $this->getReferralsRecursive($user_id);

        return view('cabinet', [
            'video' => $video,
            'balance' => $balance,
            'blockForm' => $blockForm,
            'selectVideo' => $selectVideo,
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
//        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
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
}
