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
use Illuminate\Support\Facades\Log;
use Exception;

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
        try {
            $sales = Sale::where('employee_id', $this->employee->id)
                ->whereDate('created_at', today())
                ->get();

            if ($sales->isEmpty()) {
                throw new Exception("Não há vendas registradas para o vendedor hoje.");
            }

            $totalSales = $sales->count();
            $valueTotalSales = $sales->sum('value');
            $commission = $valueTotalSales * 0.085; // 8.5% de comissão

            Mail::to($this->employee->email)
                ->send(new CommissionEmail($this->employee, $totalSales, $valueTotalSales, $commission));

        } catch (Exception $e) {
            Log::error("Erro ao enviar e-mail para o vendedor: " . $e->getMessage());

            // TODO: notificar o administrador sobre o erro
        }
    }
}
