<?php

namespace App\Console\Commands;

use App\Models\CommissionRecord;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class PartnerProgramForOtherUsers extends Command
{
    const FIRST_LINE_PERCENTAGE = 1;
    const SECOND_LINE_PERCENTAGE = 2;
    const THIRD_LINE_PERCENTAGE = 3;
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
//            \Log::info('$user', $user->toArray());
//            \Log::info('---------------------------');
            // Отримати його рефералів перших трьох ліній (масив айдішніків)
            $referrals = $this->getReferralsRecursive($user->id);
//            \Log::info('Список айдішок рефералів: ', $referrals);
//            \Log::info('$referrals', array_values($referrals));
//            foreach ($referrals as $userId => $level) {
//                \Log::info("User ID: $userId, Level: $level");
//            }
//            \Log::info('==================================');
//            \Log::info('==================================');
//            \Log::info('==================================');

            foreach ($referrals as $referral) {
//                \Log::info("ЯКИЙ ПРИЛІТАЄ ЮЗЕР: ", ['user_id' => $referral]);
                $programPurchased = $this->checkIfProgramPurchased($referral);
                // Перевірка результату чи програма була куплена у цього реферала
//                if ($programPurchased) {
//                    \Log::info("Програма куплена: " . $referral['user_id']);
//                } else {
//                    \Log::info("Програма НЕ куплена: " . $referral['user_id']);
//                }
//                \Log::info('==================================');

                $paymentsMade = $this->checkIfPaymentsMade($referral);
                // Перевірка результату чи були знянні кошти
//                if ($paymentsMade) {
//                    \Log::info("Кошти зняті:");
//                } else {
//                    \Log::info("Кошти не зняті:");
//                }
//                \Log::info('==================================');

                if ($programPurchased && $paymentsMade) {

                    $programReferral = ProgramsUser::where('user_id', $referral['user_id'])
                        ->whereNull('payment_program')
                        ->first();

                    $commissionRecord = CommissionRecord::where('user_id', $user->id)
                        ->where('referral_id', $referral['user_id'])
                        ->where('program_id', $programReferral->id)
                        ->exists();

                    if (!$commissionRecord) {
                        // Відсутній запис, викликаємо метод calculateCommission
                        $this->calculateCommission($referral, $user);

                        // Записуємо новий запис в таблицю commission_records
                        CommissionRecord::create([
                            'user_id' => $user->id,
                            'referral_id' => $referral['user_id'],
                            'program_id' => $programReferral->id,
                        ]);
                    } else {
                        // Запис вже існує, можна пропустити обчислення відсотків
//                        \Log::info("Запис про нарахування вже існує для користувача $user->id, реферала $referral[user_id] та програми $programReferral->id");
                    }
                }
            }
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
//        \Log::info("Тут айдішка реферала:" . $directReferrals);


//        foreach ($directReferrals as $referral) {
//            $referrals[$referral->user_id] = $level; // Зберігаємо рівень реферала
//            \Log::info("ID реферала:" . $referrals[$referral->user_id]);
//        }

        // Додати всіх прямих рефералів до загального списку рефералів
//        $referrals = array_merge($referrals, $directReferrals);

        // Рекурсивно отримати рефералів для кожного прямого реферала
        foreach ($directReferrals as $referralId) {
            // Рекурсивно отримати рефералів для кожного прямого реферала
            $this->getReferralsRecursive($referralId, $referrals, $level + 1);
            // Додати прямого реферала з відповідним рівнем
            $referrals[] = ['user_id' => $referralId, 'level' => $level];
        }

        // Впорядкувати масив за рівнем
        usort($referrals, function ($a, $b) {
            return $a['level'] <=> $b['level'];
        });

        return $referrals;
    }

    private function checkIfProgramPurchased($userId)
    {
//        $programPurchased = ProgramsUser::where('user_id', $userId)
        $programPurchased = ProgramsUser::where('user_id', $userId['user_id'])
            ->whereNull('payment_program')
            ->first();

        return $programPurchased ? true : false;
    }

    private function checkIfPaymentsMade($userId)
    {
        $paymentsMade = ProgramsUser::where('user_id', $userId['user_id'])
            ->where('first_withdrawal', 1)
            ->where('second_withdrawal', 1)
            ->where('third_withdrawal', 1)
            ->whereNull('payment_program')
            ->first();

        return $paymentsMade ? true : false;
    }

    private function calculateCommission($referral, $user)
    {
//        \Log::info("Рівень реферала: " . $referral['level']);
        $commissionPercentages = [
            1 => self::FIRST_LINE_PERCENTAGE,   // Відсоток для першої лінії
            2 => self::SECOND_LINE_PERCENTAGE,   // Відсоток для другої лінії
            3 => self::THIRD_LINE_PERCENTAGE,   // Відсоток для третьої лінії
        ];
//        \Log::info("Значення з масиву : " . $commissionPercentages[$referral['level']] . "%");
        if (isset($commissionPercentages[$referral['level']])) {
            $commissionPercentage = $commissionPercentages[$referral['level']];

            $programReferral = ProgramsUser::where('user_id', $referral['user_id'])
                ->where('first_withdrawal', 1)
                ->where('second_withdrawal', 1)
                ->where('third_withdrawal', 1)
                ->whereNull('payment_program')
                ->first();
//            \Log::info("Програма реферала, сума: " . $programReferral->total_amount);

            $commissionAmount = $programReferral->total_amount * $commissionPercentage / 100;
//            \Log::info("Реферальний дохід: " . $commissionAmount);

            $typeTransaction = null;
            switch ($referral['level']) {
                case 1:
                    $typeTransaction = Transaction::REFERRAL_INTEREST_FIRST_LINE;
                    break;
                case 2:
                    $typeTransaction = Transaction::REFERRAL_INTEREST_SECOND_LINE;
                    break;
                case 3:
                    $typeTransaction = Transaction::REFERRAL_INTEREST_THIRD_LINE;
                    break;
            }

            Transaction::create([
                'user_id' => $user->id,
                'type_transaction' => $typeTransaction,
                'amount' => $commissionAmount,
                'purses_type' => 1,
            ]);

            $userPurse = Purse::where('user_id', $user->id)->first();
            $userPurse->amount += $commissionAmount;
            $userPurse->save();
        }
        return 0;
    }


}
