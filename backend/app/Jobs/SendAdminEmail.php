<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Helpers\ErrorHelper;
use App\Mail\DailySalesReportEmail;
use App\Models\Sale;
use Exception;

class SendAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Handle the job to send the daily sales report email to the administrator.
     *
     * @return void
     * @throws \Exception If the admin email is not configured or no sales are registered for the day.
     */
    public function handle()
    {
        try {
            $adminEmail = config('mail.admin_email'); // Defined in the .env file

            if (!$adminEmail) {
                throw new Exception("E-mail do administrador não está configurado.");
            }

            $totalSalesOfDay = Sale::whereDate('created_at', today())->sum('value');
            $totalSalesCount = Sale::whereDate('created_at', today())->count();

            if ($totalSalesCount === 0) {
                throw new Exception("Nenhuma venda registrada para o dia de hoje.");
            }

            // Send the email to the administrator
            Mail::to($adminEmail)
                ->send(new DailySalesReportEmail($totalSalesOfDay, $totalSalesCount));

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
        }
    }
}
