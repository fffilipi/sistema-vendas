<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySalesReportEmail;
use App\Models\Sale;

class SendAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Enviar e-mail para o administrador com o total de vendas do dia
        $adminEmail = config('mail.admin_email'); // Defina isso no .env
        $totalSalesOfDay = Sale::whereDate('created_at', today())->sum('value');
        $totalSalesCount = Sale::whereDate('created_at', today())->count();

        // Envia o e-mail para o administrador
        Mail::to($adminEmail)
            ->send(new DailySalesReportEmail($totalSalesOfDay, $totalSalesCount));
    }
}
