<?php

namespace App\Console\Commands;

use App\Models\Program;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckVideoConfirmationTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:check-confirmation-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the time elapsed since video confirmation for each user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videos = Video::where('is_approved', 1)
            ->where('is_program', 0)
            ->get();



        foreach ($videos as $video) {
            // Перевірка скільки пройшло часу з підтвердження відео
            $confirmationTime = Carbon::parse($video->updated_at);
//            \Log::info('ЧАС '.json_encode($confirmationTime));
            $currentTime = Carbon::now();
//            \Log::info('ЧАС '.json_encode($currentTime));
            $elapsedHours = $currentTime->diffInHours($confirmationTime);
//            \Log::info('ЧАС '.json_encode($elapsedHours));

            // Отримання програми
            $userProgram = ProgramsUser::where('user_id', $video->user_id)
                ->whereNull('payment_program')
                ->first();
//            \Log::info('User Program: '.json_encode($userProgram));

            // Отримання даних про програму, яку вибрав юзер
            $program = Program::where('id', $userProgram->program_id)->first();
//            \Log::info('Program: '.json_encode($program));

            // Отримання гаманця
            $userPurse = Purse::where('user_id', $video->user_id)->first();
//            \Log::info('Purse: '.json_encode($userPurse));

            if ($elapsedHours >= 24) {
                $withdrawals = [
                    'first_withdrawal' => $program->first_amount,
                    'second_withdrawal' => $program->second_amount,
                    'third_withdrawal' => $program->third_amount,
                ];

                foreach ($withdrawals as $withdrawalField => $amountToWithdraw) {
                    if ($userProgram->$withdrawalField === null) {
                        // Перевірка наявності коштів на балансі користувача
                        if ($userPurse->amount >= $amountToWithdraw) {
                            $userProgram->$withdrawalField = true;
                            $userProgram->total_amount += $amountToWithdraw;
                            $userProgram->save();

                            // Списання коштів з балансу користувача
                            $userPurse->amount -= $amountToWithdraw;
                            $userPurse->save();

                            Transaction::create([
                                'user_id' => $video->user_id,
                                'amount' => -$amountToWithdraw,
                                'type_transaction' => Transaction::WITHDRAWAL_PACKAGE,
                                'purses_type' => Purse::I_HEALTH_PURSE
                            ]);

                            $video->touch();

                            break; // Виходимо з циклу після першого успішного списання
                        } else {
                            // Якщо коштів недостатньо, закриваємо програму зі штрафом
                            $this->closeProgramWithPenalty($userProgram, $userPurse, $video);
                            break; // Виходимо з циклу, оскільки програму закрито
                        }
                    }
                }
            }
        }
        $this->info('Video confirmation times checked successfully.');
    }


    protected function closeProgramWithPenalty($userProgram, $userPurse, $video)
    {
        $amountToWithdraw = ProgramsUser::where('user_id', $video->user_id)
            ->whereNull('payment_program')
            ->first()->total_amount;
        // Штраф складає 30% від суми, яку вже списано з балансу
        $penaltyAmount = $amountToWithdraw * 0.3;
        $amountToWithdraw -= $penaltyAmount;

        // Повернення коштів на баланс користувача зі знижкою
        $userPurse->amount += $amountToWithdraw;
        $userPurse->save();

        Transaction::create([
            'user_id' => $video->user_id,
            'amount' => $amountToWithdraw,
            'type_transaction' => Transaction::WITHDRAWAL_PACKAGE_PENALTY,
            'purses_type' => Purse::I_HEALTH_PURSE
        ]);

        // Закриття програми зі штрафом
        $userProgram->update(['payment_program' => 1]);

        $video->is_program = 1;
        $video->save();
        $video->touch();
    }
}
