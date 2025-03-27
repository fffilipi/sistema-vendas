<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class DailySalesReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $totalSalesOfDay;
    public $totalSales;
    public $today;

    /**
     * Crie uma nova instância do mailable.
     *
     * @param  float  $totalSalesOfDay
     * @param  int  $totalSales
     * @return void
     */
    public function __construct($totalSalesOfDay, $totalSales)
    {
        $this->totalSalesOfDay = $totalSalesOfDay;
        $this->totalSales = $totalSales;
        $this->today = Carbon::today()->format('d/m/Y');
    }

    /**
     * Defina o conteúdo do e-mail.
     *
     * @return \Illuminate\View\View
     */
    public function build()
    {
        return $this->view('emails.daily_report')
            ->with([
                'valueTotalSales' => $this->totalSalesOfDay,
                'totalSales' => $this->totalSales,
                'today' => $this->today,
            ])
            ->subject('Relatório de Vendas Diário');
    }
}
