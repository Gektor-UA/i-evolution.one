<?php

namespace App\Console\Commands;

use App\Models\Purse;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;
use function Laravel\Prompts\alert;

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
        $videos = Video::whereNotNull('is_approved')->get();

        foreach ($videos as $video) {
            // Перевірка скільки пройшло часу з підтвердження відео
            $confirmationTime = Carbon::parse($video->created_at);
            $currentTime = Carbon::now();
            $elapsedHours = $currentTime->diffInHours($confirmationTime);

            $user = User::where('id', $video->user_id)->first();

            $userPurse = Purse::where('user_id', $video->user_id)->first();
//            \Log::info('Purse: '.json_encode($userPurse));

            if ($elapsedHours >= 24) {
                $userPurse->amount = $userPurse->amount + 10.00;
            } else {
                $userPurse->amount = $userPurse->amount + 20.00;
            }
            $userPurse->save();
        }

        $this->info('Video confirmation times checked successfully.');
    }
}
