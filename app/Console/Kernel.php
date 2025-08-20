<?php

namespace App\Console;

use App\Console\Commands\DeleteOldUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CalculateHeadcount;
use App\Console\Commands\UpdateFechaHabilitadaCronJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CalculateHeadcount::class,
        UpdateFechaHabilitadaCronJob::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('calculate:headcount')->daily();
        $schedule->command('check:anniversaries')->daily();
        $schedule->command('cron:update-fecha-habilitada')->daily();
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
