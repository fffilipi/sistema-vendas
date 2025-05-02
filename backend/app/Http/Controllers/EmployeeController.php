<?php
namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Store a new employee in the database.
     *
     * @param StoreEmployeeRequest $request The HTTP request containing 'name' and 'email'.
     * @return \Illuminate\Http\JsonResponse 
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->validated());
    
            return ResponseHelper::success($employee, 201);
    
        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao cadastrar o funcionário. Tente novamente mais tarde.', $e->getCode());
        }
    }

    /**
     * Retrieve a list of all employees.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the list of employees or an error message.
     */
    public function index()
    {
        try {
            $employees = Employee::orderBy('created_at', 'desc')->get();
            return ResponseHelper::success($employees);
        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao buscar a lista de funcionários.', $e->getCode());
        }
    }

    /**
     * Update an existing employee in the database.
     *
     * @param UpdateEmployeeRequest $request The HTTP request containing 'name' and 'email'.
     * @param int $id The ID of the employee to update.
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated employee or an error message.
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->update($request->validated());
    
            return ResponseHelper::success($employee);
    
        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao atualizar os dados do funcionário.', $e->getCode());
        }
    }

    /**
     * Delete an employee from the database.
     *
     * @param int $id The ID of the employee to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
    
            return ResponseHelper::success('Funcionário deletado com sucesso');
    
        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao deletar o funcionário.', $e->getCode());
        }
    }
}
