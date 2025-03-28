<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Exception;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'value' => 'required|numeric',
                'sale_date' => 'required|date',
            ]);

            $sale = Sale::create($validated);
            return response()->json($sale, 201);

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
            $sales = Sale::with('employee:id,name')->orderBy('sale_date', 'desc')->get();
            return response()->json($sales);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar vendas',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function salesForEmployee($vendedorId)
    {
        try {
            $sales = Sale::where('employee_id', $vendedorId)->get();
            return response()->json($sales);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar vendas do vendedor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
