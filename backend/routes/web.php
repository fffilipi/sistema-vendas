<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('api/vendedores', EmployeeController::class);
Route::apiResource('api/vendas', SaleController::class);
Route::get('api/vendas/vendedor/{vendedorId}', [SaleController::class, 'salesForEmployee']);