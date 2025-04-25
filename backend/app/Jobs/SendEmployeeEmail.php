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

    /**
     * The employee instance for whom the email will be sent.
     *
     * @var Employee
     */
    protected $employee;

    /**
     * Create a new job instance.
     *
     * @param Employee $employee The employee instance.
     * @return void
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Handle the job to send the commission email to the employee.
     *
     * @return void
     * @throws \Exception If no sales are registered for the employee today.
     */
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
            $commission = $valueTotalSales * 0.085; // 8.5% commission

            // Send the email to the employee
            Mail::to($this->employee->email)
                ->send(new CommissionEmail($this->employee, $totalSales, $valueTotalSales, $commission));

        } catch (Exception $e) {
            Log::error("Erro ao enviar e-mail para o vendedor: " . $e->getMessage());

            // TODO: notify the administrator about the error
        }
    }
}
