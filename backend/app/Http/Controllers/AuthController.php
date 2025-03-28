<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);

        } catch (Exception $e) {
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());

            return response()->json(['message' => 'Erro ao registrar usuário'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::guard('web')->attempt($credentials)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $user = Auth::guard('web')->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token]);

        } catch (Exception $e) {
            Log::error('Erro ao realizar login: ' . $e->getMessage());

            return response()->json(['message' => 'Erro ao realizar login'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso']);

        } catch (Exception $e) {
            Log::error('Erro ao realizar logout: ' . $e->getMessage());

            return response()->json(['message' => 'Erro ao realizar logout'], 500);
        }
    }
}
