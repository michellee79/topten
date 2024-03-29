<?php

namespace App\Console;
use App\Helper\MailHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Helper\CronHelper;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->call(function(){
            CronHelper::send14DayExpireEmails();
        })->daily();

        $schedule->call(function(){
            CronHelper::syncUsers();
        })->hourly();
    }
}
