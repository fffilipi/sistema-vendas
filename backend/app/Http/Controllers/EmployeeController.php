<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Store a new employee in the database.
     *
     * @param Request $request The HTTP request containing 'name' and 'email'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created employee or an error message.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:employees',
            ]);

            $employee = Employee::create($validated);
            return response()->json($employee, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validação falhou',
                'message' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
            ], 500);
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
            return response()->json($employees);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar funcionários',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing employee in the database.
     *
     * @param Request $request The HTTP request containing 'name' and 'email'.
     * @param int $id The ID of the employee to update.
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated employee or an error message.
     */
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:employees,email,' . $id,
            ]);

            $employee->update($validated);
            return response()->json($employee);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validação falhou',
                'message' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar funcionário',
                'message' => $e->getMessage(),
            ], 500);
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

            return response()->json(['message' => 'Funcionário deletado com sucesso']);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao deletar funcionário',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
