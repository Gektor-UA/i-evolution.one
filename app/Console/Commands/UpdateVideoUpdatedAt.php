<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateVideoUpdatedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-video-updated-at';

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
        $ambassadors = User::where('is_ambassador', 1)->pluck('id');
        $this->info('Total ambassadors: ' . $ambassadors);

        $commonUsers = User::whereRaw('id % 2 = 0')
            ->whereNotIn('id', $ambassadors)
            ->pluck('id');
        $this->info('Total commonUsers: ' . $commonUsers);

        $users = $ambassadors->concat($commonUsers);
        $this->info('Total users: ' . $users);



        foreach ($users as $user) {
            $videos = Video::where('user_id', $user)
                ->where('is_program', 0)
                ->get();
//            $this->info('Total videos: ' . $videos);

            if (!$videos->isEmpty()) {
                foreach ($videos as $video) {
                    $video->update(['updated_at' => Carbon::now()->subDay()]);
                }
            }
        }

//        $this->info('Videos updated successfully.');
    }
}
