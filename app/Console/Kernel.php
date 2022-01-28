<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use  App\Console\Commands\CheckTask;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CheckTask::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $seconds = 5;
        $schedule->call(function () use ($seconds, $schedule) {
            $dt = \Carbon\Carbon::now();
            $x = 60 / $seconds;
            do {
                \Artisan::call('check:task');
                \Log::debug($x . ' executing at ' . date('Y-m-d H:i:s'));
                time_sleep_until($dt->addSeconds($seconds)->timestamp);
            } while ($x-- > 1);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
