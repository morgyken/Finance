<?php

namespace Ignite\Finance\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the package's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);
        $schedule->command('finance:fix-prescription')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('finance:prepare-payments')->everyMinute()->withoutOverlapping();
    }
}