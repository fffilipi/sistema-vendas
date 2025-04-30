<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
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

            return ResponseHelper::success($sale, 201);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao cadastrar a venda. Tente novamente mais tarde.');
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
                    $sale->sale_date = Carbon::parse($sale->sale_date)->format('d/m/Y');
                    return $sale;
                });

            return ResponseHelper::success($sales);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao buscar vendas.');
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

            return ResponseHelper::success($sales);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao buscar vendas do vendedor.');
        }
    }
}
