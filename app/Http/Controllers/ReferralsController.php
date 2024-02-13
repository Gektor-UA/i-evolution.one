<?php

namespace App\Http\Controllers;

use App\Models\ReferralsUser;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralsController extends Controller
{
    /**
     * Отримання всіх рефералів користувача та їхніх рефералів.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function getReferrals($userId)
    {
        // Починаємо з користувача з вказаним ID
        $referrals = $this->getReferralsRecursive($userId);

        return $referrals;
    }

// Рекурсивний метод для отримання всіх рефералів користувача та їхніх рефералів
    private function getReferralsRecursive($userId, &$referrals = [])
    {
        // Отримуємо всіх рефералів поточного користувача
        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();

        // Додаємо всіх прямих рефералів до загального списку рефералів
        $referrals = array_merge($referrals, $directReferrals);

        // Рекурсивно обходимо кожного реферала та шукаємо їх рефералів
        foreach ($directReferrals as $referralId) {
            $this->getReferralsRecursive($referralId, $referrals);
        }

        return $referrals;
    }
}
