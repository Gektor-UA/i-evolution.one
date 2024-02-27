<?php

namespace App\Console\Commands;

use App\Models\Program;
use App\Models\ProgramsUser;
use App\Models\Purse;
use App\Models\Transaction;
use App\Models\Video;
use Illuminate\Console\Command;

class PaymentByPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:payment-by-package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charging the corresponding amount after 2 days from the last video update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videos = Video::where('updated_at', '<=', now()->subDays(3))
            ->where('is_program', 0)
            ->get();
//        \Log::info('videos: '.json_encode($videos));

        foreach ($videos as $video) {
            $userProgram = ProgramsUser::where('user_id', $video->user_id)->first();
//            \Log::info('$userProgram: '.json_encode($userProgram));

            $program = Program::where('id', $userProgram->program_id)->first();
//            \Log::info('$program: '.json_encode($program));

            if ($program && $program->income_program) {
                $userPurse = Purse::where('user_id', $video->user_id)->first();

                if ($userPurse) {
                    $userPurse->amount += $program->income_program;
                    $userPurse->save();

                    Transaction::create([
                        'user_id' => $video->user_id,
                        'amount' => $program->income_program,
                        'type_transaction' => Transaction::PAYMENT_BY_PACKAGE,
                        'purses_type' => Purse::I_HEALTH_PURSE
                    ]);

                    $video->is_program = 1; // Встановлюємо позначку, що по цьому відео програма закрита
                    $video->save();

                    $userProgram->payment_program = 1; // Закриваємо програму, виплата здійснена або був штраф
                    $userProgram->save();
                }
            }
        }

        $this->info('Сума нарахована успішно.');
    }
}
