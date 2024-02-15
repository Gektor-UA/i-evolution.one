<?php

namespace App\Console\Commands;

use App\Models\BonusClosingProgram;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\SingleAccruals;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class PartnerProgramForAmbassadors extends Command
{
    const BONUS_AMOUNT_FIRST_LINE = 5;
    const BONUS_AMOUNT_SECOND_LINE = 6;
    const BONUS_AMOUNT_THIRD_LINE = 7;
    const BONUS_AMOUNT_FOURTH_LINE = 8;
    const BONUS_AMOUNT_FIFTH_LINE = 9;
    const BONUS_AMOUNT_SIXTH_LINE = 10;

    const BONUS_PERCENTAGE_FIRST_LINE = 1;
    const BONUS_PERCENTAGE_SECOND_LINE = 2;
    const BONUS_PERCENTAGE_THIRD_LINE = 3;
    const BONUS_PERCENTAGE_FOURTH_LINE = 4;
    const BONUS_PERCENTAGE_FIFTH_LINE = 5;
    const BONUS_PERCENTAGE_SIXTH_LINE = 6;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:partner-program-for-ambassadors';

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
        $ambassadors = User::where('is_ambassador', 1)->get();
        foreach ($ambassadors as $ambassador) {

//            \Log::info('$ambassador', $ambassador->toArray());
            $referrals = $this->getReferralsRecursive($ambassador->id);
//            \Log::info('Список айдішок рефералів: ', $referrals);
//            \Log::info('$referrals', array_values($referrals));
//            \Log::info('---------------------------');


            foreach ($referrals as $referral) {

//                \Log::info('Ambassador ID: ' . $ambassador->id);
//                \Log::info('Referral ID: ' . $referral['user_id']);
                $userSingleAccruals = SingleAccruals::where('user_id', $ambassador->id)
                    ->where('referral_id', $referral['user_id'])
                    ->exists();
                if (!$userSingleAccruals) {
                    $this->singleAccruals($ambassador, $referral);
                }

                $userClosingProgram = BonusClosingProgram::where('user_id', $ambassador->id)
                    ->where('referral_id', $referral['user_id'])
                    ->exists();
                if (!$userClosingProgram) {
                    $this->bonusClosingProgram($ambassador, $referral);
                }
            }
        }
    }

    /**
     * Метод рекурсивного отримання рефералів
     * @param $userId
     * @param array $referrals
     * @param int $level
     * @return array
     */
    private function getReferralsRecursive($userId, &$referrals = [], $level = 1)
    {

            // Виводити тільки 6 ліній рефералів
            if ($level > 6) {
                return [];
            }

            // Отримати прямих рефералів поточного користувача
            $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
//            \Log::info('Масив прямих рефералів', $directReferrals);

            // Рекурсивно отримати рефералів для кожного прямого реферала
            foreach ($directReferrals as $referralId) {

                // Перевірка чи є користувач амбасадором
                $isUserAmbassador = User::where('id', $referralId)
                    ->where('is_ambassador', 1)
                    ->first();

                // Додати прямого реферала з відповідним рівнем
                $referrals[] = ['user_id' => $referralId, 'level' => $level];

                if (!$isUserAmbassador) {
                    // Рекурсивно отримати рефералів для кожного прямого реферала, які не є амбасадорами
                    $this->getReferralsRecursive($referralId, $referrals, $level + 1);
                }


            }

            // Впорядкувати масив за рівнем
            usort($referrals, function ($a, $b) {
                return $a['level'] <=> $b['level'];
            });

            return $referrals;
    }

    /**
     * Метод для одиничного нарахування бонусу за закриту програму для юзера від його реферала
     * з перших 6 ліній
     * @param $user
     * @param $referral
     */
    private function singleAccruals($user, $referral) {

        $programReferral = ProgramsUser::where('user_id', $referral['user_id'])
            ->where('first_withdrawal', 1)
            ->where('second_withdrawal', 1)
            ->where('third_withdrawal', 1)
            ->whereNull('payment_program')
            ->first();

        if ($programReferral) {
            $bonusAmount = [
                1 => self::BONUS_AMOUNT_FIRST_LINE,   // Сума бонусу для першої лінії
                2 => self::BONUS_AMOUNT_SECOND_LINE,   // Сума бонусу для другої лінії
                3 => self::BONUS_AMOUNT_THIRD_LINE,   // Сума бонусу для третьої лінії
                4 => self::BONUS_AMOUNT_FOURTH_LINE,   // Сума бонусу для третьої лінії
                5 => self::BONUS_AMOUNT_FIFTH_LINE,   // Сума бонусу для третьої лінії
                6 => self::BONUS_AMOUNT_SIXTH_LINE,   // Сума бонусу для третьої лінії
            ];

            $commissionAmount = $bonusAmount[$referral['level']];
//            \Log::info('Type of $commissionAmount: ' . gettype($commissionAmount));

            $typeTransaction = null;
            switch ($referral['level']) {
                case 1:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_FIRST_LINE;
                    break;
                case 2:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_SECOND_LINE;
                    break;
                case 3:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_THIRD_LINE;
                    break;
                case 4:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_FOURTH_LINE;
                    break;
                case 5:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_FIFTH_LINE;
                    break;
                case 6:
                    $typeTransaction = Transaction::FIRST_BONUS_AMBASSADOR_SIXTH_LINE;
                    break;
            }
            Transaction::create([
                'user_id' => $user->id,
                'type_transaction' => $typeTransaction,
                'amount' => $commissionAmount,
                'purses_type' => 1,
            ]);
            // Записуємо програму в цю таблицю, щоб прибрати повтор нарахуванб по цій програмі
            SingleAccruals::create([
                'user_id' => $user->id,
                'referral_id' => $referral['user_id'],
                'program_id' => $programReferral->id,
            ]);
            $userPurse = Purse::where('user_id', $user->id)
                ->where('wallet_type', 1)
                ->first();
            $userPurse->amount += $commissionAmount;
            $userPurse->save();
        }
    }

    private function bonusClosingProgram($user, $referral) {
        $programReferral = ProgramsUser::where('user_id', $referral['user_id'])
            ->where('first_withdrawal', 1)
            ->where('second_withdrawal', 1)
            ->where('third_withdrawal', 1)
            ->where('payment_program', 1)
            ->first();

        if ($programReferral) {

            $bonusAmount = [
                1 => self::BONUS_PERCENTAGE_FIRST_LINE,   // Сума бонусу для першої лінії
                2 => self::BONUS_PERCENTAGE_SECOND_LINE,   // Сума бонусу для другої лінії
                3 => self::BONUS_PERCENTAGE_THIRD_LINE,   // Сума бонусу для третьої лінії
                4 => self::BONUS_PERCENTAGE_FOURTH_LINE,   // Сума бонусу для третьої лінії
                5 => self::BONUS_PERCENTAGE_FIFTH_LINE,   // Сума бонусу для третьої лінії
                6 => self::BONUS_PERCENTAGE_SIXTH_LINE,   // Сума бонусу для третьої лінії
            ];

            $typeTransaction = null;
            switch ($referral['level']) {
                case 1:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_FIRST_LINE;
                    break;
                case 2:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_SECOND_LINE;
                    break;
                case 3:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_THIRD_LINE;
                    break;
                case 4:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_FOURTH_LINE;
                    break;
                case 5:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_FIFTH_LINE;
                    break;
                case 6:
                    $typeTransaction = Transaction::SECOND_BONUS_AMBASSADOR_SIXTH_LINE;
                    break;
            }
            $commissionAmount = $bonusAmount[$referral['level']];
            Transaction::create([
                'user_id' => $user->id,
                'type_transaction' => $typeTransaction,
                'amount' => $commissionAmount,
                'purses_type' => 1,
            ]);
            // Записуємо програму в цю таблицю, щоб прибрати повтор нарахуванб по цій програмі
            BonusClosingProgram::create([
                'user_id' => $user->id,
                'referral_id' => $referral['user_id'],
                'program_id' => $programReferral->id,
            ]);
            $userPurse = Purse::where('user_id', $user->id)
                ->where('wallet_type', 1)
                ->first();
            $userPurse->amount += $commissionAmount;
            $userPurse->save();
        }
    }
}
