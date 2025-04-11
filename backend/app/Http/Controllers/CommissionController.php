<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmployeeEmail;
use App\Models\Employee;

class CommissionController extends Controller
{
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