<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // для роботи
        $schedule->command('video:check-confirmation-time')->hourly();
        $schedule->command('video:payment-by-package')->hourly();

        $schedule->command('app:partner-program-for-other-users')->daily()->at('03:00');
        $schedule->command('app:partner-program-for-ambassadors')->daily()->at('03:00');

        // для тестування
//        $schedule->command('video:check-confirmation-time')->everyMinute();
//        $schedule->command('video:payment-by-package')->everyMinute();
//
//        $schedule->command('app:partner-program-for-other-users')->everyMinute();
//        $schedule->command('app:partner-program-for-ambassadors')->everyMinute();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
