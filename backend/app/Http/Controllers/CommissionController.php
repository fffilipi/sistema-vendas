<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
use App\Jobs\SendEmployeeEmail;
use App\Models\Employee;
use Exception;

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

            return ResponseHelper::success('E-mail de comissão reenviado com sucesso!');
        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao reenviar o e-mail de comissão. Tente novamente mais tarde.');
        }
    }
}
            