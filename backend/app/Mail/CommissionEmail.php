<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CommissionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $totalSales;
    public $valueTotalSales;
    public $commission;
    public $today;

    /**
     * Crie uma nova instância do mailable.
     *
     * @param  \App\Models\Employee  $employee
     * @param  float  $totalSales
     * @param  float  $valueTotalSales
     * @param  float  $commission
     * @return void
     */
    public function __construct(Employee $employee, $totalSales, $valueTotalSales, $commission)
    {
        $this->employee = $employee;
        $this->totalSales = $totalSales;
        $this->valueTotalSales = $valueTotalSales;
        $this->commission = $commission;
        $this->today = Carbon::today()->format('d/m/Y');
    }

    /**
     * Defina o conteúdo do e-mail.
     *
     * @return \Illuminate\View\View
     */
    public function build()
    {
        return $this->view('emails.commission')
            ->with([
                'name' => $this->employee->name,
                'totalSales' => $this->totalSales,
                'valueTotalSales' => $this->valueTotalSales,
                'commission' => $this->commission,
                'today' => $this->today,
            ])
            ->subject('Relatório de Vendas - Comissão');
    }
}
