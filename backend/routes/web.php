<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ComissaoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/login', [AuthController::class, 'login']);
Route::post('api/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('api/vendedores', EmployeeController::class);
    Route::apiResource('api/vendas', SaleController::class);
    Route::get('api/vendas/vendedor/{vendedorId}', [SaleController::class, 'salesForEmployee']);
    Route::post('api/logout', [AuthController::class, 'logout']);
    Route::post('api/reenvio-comissao/{vendedor_id}', [ComissaoController::class, 'reenviarRelatorioComissao']);
});
