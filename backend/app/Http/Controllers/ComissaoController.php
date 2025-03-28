<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmployeeEmail;
use App\Models\Employee;

class ComissaoController extends Controller
{
    public function reenviarRelatorioComissao($vendedor_id)
    {
        try {
            $vendedor = Employee::findOrFail($vendedor_id);
    
            SendEmployeeEmail::dispatch($vendedor);
    
            return response()->json(['message' => 'E-mail de comissão reenviado com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao reenviar o e-mail: ' . $e->getMessage()], 500);
        }
    }
}