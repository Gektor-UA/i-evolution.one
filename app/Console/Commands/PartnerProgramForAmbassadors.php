<?php

namespace App\Console\Commands;

use App\Models\BonusClosingProgram;
use App\Models\ProfileReferrer;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\SingleAccruals;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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
//        \Log::info('$ambassadors', $ambassadors->toArray());
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

            // Перевірка на кількість рефералів не включаючи структуру амбасадорів
            $this->bonusNumberReferrals($ambassador->id);

            // Перевірка на нарахування бонусу "Швидкий старт"
            $quickStartTransaction = Transaction::where('user_id', $ambassador->id)
                ->where('type_transaction', Transaction::QUICK_START)
                ->exists();
            if (!$quickStartTransaction) {
                $this->quickStart($ambassador->id);
            }

            $this->bonusNumberAmbassadors($ambassador->id);
        }
//        $userId = 3;
//        $referrals = $this->getAllReferralsRecursive($userId);
////        $referrals = count($referrals);
//        \Log::info('Кількість рефералів: ', $referrals);
//        \Log::info('===================================');
//        \Log::info('===================================');
//        \Log::info('===================================');

//        $userId = 3;
//        $referrals = $this->bonusNumberAmbassadors($userId);
//        \Log::info('Кількість рефералів: ' . $referrals);
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
//            $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
            $directReferrals = ProfileReferrer::where('referrer_id', $userId)
                ->whereNotNull('user_id')
                ->pluck('user_id')->toArray();
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

                    if ($referralId !== null) {
                        // Рекурсивно отримати рефералів для кожного прямого реферала, які не є амбасадорами
                        $this->getReferralsRecursive($referralId, $referrals, $level + 1);
                    }
                }


            }

            // Впорядкувати масив за рівнем
            usort($referrals, function ($a, $b) {
                return $a['level'] <=> $b['level'];
            });

            return $referrals;
    }

    /**
     * Метод для одиничного нарахування бонусу за зроблені 3 платежі при купівлінайпершої програми для юзера від його реферала
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

    /**
     * Метод для нарахування бонусу за закриту програму для юзера від його реферала
     * з перших 6 ліній
     * @param $user
     * @param $referral
     */
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

    /**
     * Метод повертає масив всіх рефералів для юзера не вважаючи кількість ліній
     * @param $userId
     * @param $referrals
     * @return array
     */
    private function getAllReferralsRecursive($userId, &$referrals = []) {
        // Отримати прямих рефералів поточного користувача
//        $directReferrals = ReferralsUser::where('referral_id', $userId)->pluck('user_id')->toArray();
        $directReferrals = ProfileReferrer::where('referrer_id', $userId)
            ->whereNotNull('user_id')
            ->pluck('user_id')->toArray();

        // Додати прямих рефералів до загального списку рефералів
        $referrals = array_merge($referrals, $directReferrals);

        // Рекурсивно отримати всіх рефералів для кожного прямого реферала
        foreach ($directReferrals as $referralId) {
            // Перевірка чи є користувач амбасадором
            $isUserAmbassador = User::where('id', $referralId)
                ->where('is_ambassador', 1)
                ->exists();

            if (!$isUserAmbassador) {
                if ($referralId !== null) {
                    // Рекурсивно отримати всіх рефералів для кожного прямого реферала, які не є амбасадорами
                    $this->getAllReferralsRecursive($referralId, $referrals);
                }
            }
        }

        return $referrals;
    }

    /**
     * Метод нараховує відповідні бонуси перевіряючи яка кількість рефералів поточного користувача
     * @param $userId
     */
    private function bonusNumberReferrals($userId) {
        $referralCount = $this->getAllReferralsRecursive($userId);

        $bonusAmounts = [
            1000 => 100,
            900 => 100,
            800 => 100,
            700 => 100,
            600 => 100,
            500 => 100,
            400 => 150,
            250 => 100,
            150 => 50,
            100 => 50,
            50 => 20,
            30 => 20,
            10 => 10,
        ];

        foreach ($bonusAmounts as $referrals => $bonus) {
            if (count($referralCount) >= $referrals) {

                // Перевірка, чи вже було здійснене нарахування
                $existingTransaction = Transaction::where('user_id', $userId)
                    ->where('type_transaction', Transaction::BONUS_NUMBER_REFERRALS)
                    ->where('amount', $bonus)
                    ->exists();

                if (!$existingTransaction) {
                    Transaction::create([
                        'user_id' => $userId,
                        'type_transaction' => Transaction::BONUS_NUMBER_REFERRALS,
                        'amount' => $bonus,
                        'wallet_type' => 1,
                    ]);

                    $userPurse = Purse::where('user_id', $userId)
                        ->where('wallet_type', 1)
                        ->first();

                    if ($userPurse) {
                        $userPurse->amount += $bonus;
                        $userPurse->save();
                    } else {
                        Purse::create([
                            'user_id' => $userId,
                            'type_transaction' => Transaction::BONUS_NUMBER_REFERRALS,
                            'amount' => $bonus,
                            'wallet_type' => 1,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Метод нараховує відповідні бонуси по програмі "Швидкий старт"
     * @param $userId
     */
    private function quickStart($userId) {

        $referralCount = $this->getAllReferralsRecursive($userId);
//        \Log::info($referralCount);

        $bonusAmounts = [
            1000 => 1000,
            750 => 950,
            500 => 400,
            250 => 150,
            150 => 100,
            100 => 60,
            90 => 50,
            70 => 30,
            40 => 25,
            20 => 12,
            10 => 5,
        ];

        // Сьогоднішня дата
        $currentDate = Carbon::now();
        // Дата реєстрації поточного користувача
//        $userRegistrationDate = User::find($userId)->created_at;
//        \Log::info('====================================');
//        \Log::info('Дата реєстрації користувача: ' . $userId . ' - ' . $userRegistrationDate);



        // Дата першої купрленої програми
        $userFirstProgram = ProgramsUser::where('user_id', $userId)->first();
//        \Log::info('====================================');
//        \Log::info('Перша куплена програма: ' . $userId . $userFirstProgram);
//        \Log::info('====================================');
        if ($userFirstProgram) {
            $userFirstProgram = $userFirstProgram->created_at;
//            \Log::info('====================================');
//            \Log::info('Дата першої купрленої програми: ' . $userFirstProgram);
//            \Log::info('-------------------------------------');

// Дата 90 днів після
//        $ninetyDaysLater = $userRegistrationDate->copy()->addDays(90);
            $ninetyDaysLater = $userFirstProgram->copy()->addDays(90);
//            \Log::info('Дата 90 днів після: ' . $ninetyDaysLater);
//            \Log::info('====================================');

            $referralsAddedWithin90Days = 0;

            foreach ($referralCount as $referralId) {
                $referral = User::find($referralId);
//            \Log::info('Реферал: ' . $referral);
//                if ($referral->created_at <= $ninetyDaysLater && $referral->created_at >= $userRegistrationDate) {
                if ($referral->created_at <= $ninetyDaysLater && $referral->created_at >= $userFirstProgram) {
                \Log::info('Користувач з ID: ' . $referralId . ' є рефералом і потрапляє до списку');
                    $referralsAddedWithin90Days++;
                } else {
//                \Log::info('Користувач з ID: ' . $referralId . ' є рефералом але не потрапляє до списку');
                }
            }

//        \Log::info('====================================');
//        \Log::info('Кількість рефералів до 90 днів: ' . $referrpalsAddedWithin90Days);
//        \Log::info('====================================');


            // Перевіряємо, чи пройшло 90 днів з моменту реєстрації
//            $daysSinceRegistration = $currentDate->diffInDays($userRegistrationDate);
            $daysSinceRegistration = $currentDate->diffInDays($userFirstProgram);
//        \Log::info('Пройшло днів: ' . $daysSinceRegistration);
            foreach ($bonusAmounts as $referrals => $bonus) {
                if ($referralsAddedWithin90Days >= $referrals && $daysSinceRegistration >= 90) {
                    Transaction::create([
                        'user_id' => $userId,
                        'type_transaction' => Transaction::QUICK_START,
                        'amount' => $bonus,
                        'wallet_type' => 1,
                    ]);

                    $userPurse = Purse::where('user_id', $userId)
                        ->where('wallet_type', 1)
                        ->first();
                    if ($userPurse) {
                        $userPurse->amount += $bonus;
                        $userPurse->save();
                    } else {
                        Purse::create([
                            'user_id' => $userId,
                            'type_transaction' => Transaction::QUICK_START,
                            'amount' => $bonus,
                            'wallet_type' => 1,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Метод для розрахунку бонусів по програмі "Бонус за кількість амбасадорів"
     * @param $userId
     */
    private function bonusNumberAmbassadors($userId) {
        $referralCount = $this->getAllReferralsRecursive($userId);
        $numberAmbassador = 0;

        $bonusAmounts = [
            50 => 150,
            40 => 225,
            25 => 150,
            15 => 105,
            8 => 75,
            3 => 45,
        ];

        foreach ($referralCount as $referralId) {
            $referral = User::find($referralId);
            if ($referral->is_ambassador == 1) {
                $numberAmbassador++;
            }
        }

        foreach ($bonusAmounts as $ambassadors => $bonus) {
            if ($numberAmbassador >= $ambassadors) {

                // Перевірка, чи вже було здійснене нарахування
                $existingTransaction = Transaction::where('user_id', $userId)
                    ->where('type_transaction', Transaction::AMBASSADORS)
                    ->where('amount', $bonus)
                    ->exists();

                if (!$existingTransaction) {
                    Transaction::create([
                        'user_id' => $userId,
                        'type_transaction' => Transaction::AMBASSADORS,
                        'amount' => $bonus,
                        'wallet_type' => 1,
                    ]);

                    $userPurse = Purse::where('user_id', $userId)
                        ->where('wallet_type', 1)
                        ->first();
                    if ($userPurse) {
                        $userPurse->amount += $bonus;
                        $userPurse->save();
                    } else {
                        Purse::create([
                            'user_id' => $userId,
                            'type_transaction' => Transaction::AMBASSADORS,
                            'amount' => $bonus,
                            'wallet_type' => 1,
                        ]);
                    }
                }
            }
        }
    }
}
