<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Sale;
use Exception;

class SaleController extends Controller
{
    /**
     * Store a new sale in the database.
     *
     * @param StoreSaleRequest $request The HTTP request containing 'employee_id', 'value', and 'sale_date'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created sale or an error message.
     */
    public function store(StoreSaleRequest $request)
    {
        try {
            $validated = $request->validated();
    
            $sale = Sale::create($validated);
    
            return response()->json($sale, 201);
    
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retrieve a list of all sales.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the list of sales or an error message.
     */
    public function index()
    {
        try {
            $sales = Sale::with('employee:id,name')
                ->orderBy('sale_date', 'desc')
                ->get()
                ->map(function ($sale) {
                    $sale->sale_date = \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y');
                    return $sale;
                });

            return response()->json($sales);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar vendas',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retrieve all sales for a specific employee.
     *
     * @param int $employeeId The ID of the employee whose sales will be retrieved.
     * @return \Illuminate\Http\JsonResponse A JSON response with the list of sales for the employee or an error message.
     */
    public function salesForEmployee($employeeId)
    {
        try {
            $sales = Sale::where('employee_id', $employeeId)->get();
            return response()->json($sales);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar vendas do vendedor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
