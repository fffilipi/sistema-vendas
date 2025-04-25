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
     * Create a new instance of the mailable.
     *
     * @param \App\Models\Employee $employee The employee instance.
     * @param float $totalSales The total number of sales made by the employee.
     * @param float $valueTotalSales The total value of sales made by the employee.
     * @param float $commission The commission amount calculated for the employee.
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
     * Define the content of the email.
     *
     * @return \Illuminate\View\View The view representing the email content.
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
