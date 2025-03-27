<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommissionEmail;
use App\Models\Employee;
use App\Models\Sale;

class SendEmployeeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;
    
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function handle()
    {
        // Enviar e-mail para o vendedor
        $sales = Sale::where('employee_id', $this->employee->id)
            ->whereDate('created_at', today())
            ->get();

        $totalSales = $sales->count();
        $valueTotalSales = $sales->sum('value');
        $commission = $valueTotalSales * 0.085; // 8.5% de comissão

        // Envia o e-mail para o vendedor
        Mail::to($this->employee->email)
            ->send(new CommissionEmail($this->employee, $totalSales, $valueTotalSales, $commission));
    }
}
