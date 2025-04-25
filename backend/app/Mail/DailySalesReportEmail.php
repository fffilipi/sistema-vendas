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
     * Create a new instance of the mailable.
     *
     * @param float $totalSalesOfDay The total value of sales made during the day.
     * @param int $totalSales The total number of sales made during the day.
     * @return void
     */
    public function __construct($totalSalesOfDay, $totalSales)
    {
        $this->totalSalesOfDay = $totalSalesOfDay;
        $this->totalSales = $totalSales;
        $this->today = Carbon::today()->format('d/m/Y');
    }

    /**
     * Define the content of the email.
     *
     * @return \Illuminate\View\View The view representing the email content.
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
