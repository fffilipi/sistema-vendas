<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmployeeEmail;
use App\Models\Employee;

class CommissionController extends Controller
{
    /**
     * Resend the commission report email to the specified employee.
     *
     * @param int $employeeId The ID of the employee to whom the email will be sent.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function resendReportCommission($employeeId)
    {
        try {
            $employee = Employee::findOrFail($employeeId);
    
            SendEmployeeEmail::dispatch($employee);
    
            return response()->json(['message' => 'E-mail de comissão reenviado com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao reenviar o e-mail: ' . $e->getMessage()], 500);
        }
    }
}