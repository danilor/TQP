<?php

namespace Tiqueso\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Tiqueso\Console\Commands\Inspire::class,
        'Tiqueso\Console\Commands\EnviarCorreos', /*Esta linea añade el proceso de enviar correos a a lista de comandos de artisan*/
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        $schedule->command('EnviarCorreo')->everyMinute();
    }
}
