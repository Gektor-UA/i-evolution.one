<?php

namespace App\Console\Commands;

use App\Models\ProgramsUser;
use App\Models\ReferralsUser;
use App\Models\User;
use Illuminate\Console\Command;

class PartnerProgramForOtherUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:partner-program-for-other-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Отримати всіх користувачів, які не є амбасадорами
        $nonAmbassadorUsers = User::where('is_ambassador', 0)->get();

        foreach ($nonAmbassadorUsers as $user) {
//            \Log::info('==================================');
            \Log::info('$user', $user->toArray());
//            \Log::info('---------------------------');
            // Отримати його рефералів перших трьох ліній (масив айдішніків)
            $referrals = $this->getReferralsRecursive($user->id);
            \Log::info('$referrals', $referrals);
//            \Log::info('$referrals', array_values($referrals));
//            foreach ($referrals as $userId => $level) {
//                \Log::info("User ID: $userId, Level: $level");
//            }
            \Log::info('==================================');
            \Log::info('==================================');
            \Log::info('==================================');

//            if (!empty($referrals)) {
                foreach ($referrals as $referral) {
//                    \Log::info("USER: ", ['user_id' => $referral]);
                    $programPurchased = $this->checkIfProgramPurchased($referral);
                    // Перевірка результату
//                    if ($programPurchased) {
//                        \Log::info("Program was purchased by user with ID: $referral");
//                    } else {
//                        \Log::info("Program was not purchased by user with ID: $referral");
//                    }
//                    \Log::info('==================================');

                    $paymentsMade = $this->checkIfPaymentsMade($referral);
                    // Перевірка результату
//                    if ($paymentsMade) {
//                        \Log::info("There were write-offs by package:");
//                    } else {
//                        \Log::info("There were no write-offs on the package:");
//                    }
//                    \Log::info('==================================');

                    if ($programPurchased && $paymentsMade) {
                        // Розрахувати відсоток в залежності від лінії реферала
//                        $lineLevel = $this->calculateLineLevel($referral);

                        // Розрахувати суму для нарахування амбасадору
    //                    $commissionAmount = $this->calculateCommission($lineLevel, $paymentAmount);

                        // Нарахувати відповідний відсоток амбасадору
    //                    $this->accrueCommissionToAmbassador($user->id, $commissionAmount);
                    }
                }
//            }
        }
    }


    private function getReferralsRecursive($userId, &$referrals = [], $level = 1)
    {
        // Виводити тільки 3 лінії рефералів
        if ($level > 3) {
            return [];
        }

        // Отримати прямих рефералів поточного користувача
        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
//        $directReferrals = ReferralsUser::where('referral_id', $userId)->get(['user_id']);


//        foreach ($directReferrals as $referral) {
//            $referrals[$referral->user_id] = $level; // Зберігаємо рівень реферала
//        }

        // Додати всіх прямих рефералів до загального списку рефералів
        $referrals = array_merge($referrals, $directReferrals);

        // Рекурсивно отримати рефералів для кожного прямого реферала
        foreach ($directReferrals as $referralId) {
            $this->getReferralsRecursive($referralId, $referrals, $level + 1);
        }

        return $referrals;
    }

    private function checkIfProgramPurchased($userId)
    {
        $programPurchased = ProgramsUser::where('user_id', $userId)
            ->where('payment_program', null)
            ->first();

        if ($programPurchased) {
            return true;
        } else {
            return false;
        }
    }

    private function checkIfPaymentsMade($userId)
    {
        $paymentsMade = ProgramsUser::where('user_id', $userId)
            ->where('first_withdrawal', 1)
            ->where('second_withdrawal', 1)
            ->where('third_withdrawal', 1)
            ->whereNull('payment_program')
            ->first();
        return $paymentsMade ? true : false;
    }

    private function calculateLineLevel($lineLevel)
    {
        // Реалізація логіки для розрахунку відсотка в залежності від рівня лінії
    }

    private function calculateCommission($lineLevel, $paymentAmount)
    {
        // Реалізація логіки для розрахунку комісії
    }

    private function accrueCommissionToAmbassador($userId, $commissionAmount)
    {
        // Реалізація логіки для нарахування комісії амбасадору
    }
}
