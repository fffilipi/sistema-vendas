<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendEmployeeEmail;
use App\Jobs\SendAdminEmail;
use App\Models\Employee;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * This method schedules two tasks to run daily at specific times:
     * - Sends emails to all employees at the time specified by the `EMPLOYEE_EMAIL_TIME` environment variable.
     * - Sends an email to the admin at the time specified by the `ADMIN_EMAIL_TIME` environment variable.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule The schedule instance used to define tasks.
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $employeeEmailTime = env('EMPLOYEE_EMAIL_TIME', '20:00');
        $adminEmailTime = env('ADMIN_EMAIL_TIME', '20:00');

        $schedule->call(function () {
            $employees = Employee::all();

            if ($employees->isEmpty()) {
                return;
            }

            foreach ($employees as $employee) {
                SendEmployeeEmail::dispatch($employee);
            }
        })->dailyAt($employeeEmailTime);

        $schedule->call(function () {
            SendAdminEmail::dispatch();
        })->dailyAt($adminEmailTime);

    }

    /**
     * Registrar comandos do Artisan.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
