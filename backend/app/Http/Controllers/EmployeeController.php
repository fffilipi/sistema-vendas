<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class EmployeeController extends Controller
{
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

    public function index()
    {
        try {
            $employees = Employee::all();
            return response()->json($employees);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar funcionários',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

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
