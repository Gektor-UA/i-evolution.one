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

                if ($userProgram->first_withdrawal === null) {
                    $userProgram->first_withdrawal = true;
                    $userProgram->save();
                    // Здійснюємо списання з балансу користувача
                    $amountToWithdraw = $program->first_amount;
                    $userPurse->amount -= $amountToWithdraw;
                    $userPurse->save();

                    Transaction::create([
                        'user_id' => $video->user_id,
                        'amount' => -$amountToWithdraw,
                        'type_transaction' => Transaction::WITHDRAWAL_PACKAGE,
                        'purses_type' => Purse::I_HEALTH_PURSE
                    ]);

                    $video->touch();
                } elseif ($userProgram->second_withdrawal === null) {
                    $userProgram->second_withdrawal = true;
                    $userProgram->save();
                    // Здійснюємо списання з балансу користувача
                    $amountToWithdraw = $program->second_amount;
                    $userPurse->amount -= $amountToWithdraw;
                    $userPurse->save();

                    Transaction::create([
                        'user_id' => $video->user_id,
                        'amount' => -$amountToWithdraw,
                        'type_transaction' => Transaction::WITHDRAWAL_PACKAGE,
                        'purses_type' => Purse::I_HEALTH_PURSE
                    ]);

                    $video->touch();
                } elseif ($userProgram->third_withdrawal === null) {
                    $userProgram->third_withdrawal = true;
                    $userProgram->save();
                    // Здійснюємо списання з балансу користувача
                    $amountToWithdraw = $program->third_amount;
                    $userPurse->amount -= $amountToWithdraw;
                    $userPurse->save();

                    Transaction::create([
                        'user_id' => $video->user_id,
                        'amount' => -$amountToWithdraw,
                        'type_transaction' => Transaction::WITHDRAWAL_PACKAGE,
                        'purses_type' => Purse::I_HEALTH_PURSE
                    ]);

                    $video->touch();
                }
            }

        }

        $this->info('Video confirmation times checked successfully.');
    }
}
