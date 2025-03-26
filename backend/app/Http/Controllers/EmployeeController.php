<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:vendedores',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    public function index()
    {
        return response()->json(Employee::all());
    }
}
