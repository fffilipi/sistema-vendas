<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendedor_id' => 'required|exists:vendedores,id',
            'valor' => 'required|numeric',
            'data_venda' => 'required|date',
        ]);

        $sale = Sale::create($validated);
        return response()->json($sale, 201);
    }

    public function index()
    {
        return response()->json(Sale::all());
    }

    public function salesForEmployee($vendedorId)
    {
        $sales = Sale::where('vendedor_id', $vendedorId)->get();
        return response()->json($sales);
    }
}
