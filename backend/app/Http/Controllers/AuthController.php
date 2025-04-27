<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Exception;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request The HTTP request containing 'name', 'email', and 'password'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created user and token, or an error message.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if (!$user) {
                return response()->json(['message' => 'Erro ao registrar usuário'], 500);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);

        } catch (Exception $e) {
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());

            return response()->json(['message' => 'Erro ao registrar usuário'], 500);
        }
    }

    /**
     * Authenticate a user and generate an access token.
     *
     * @param LoginRequest $request The HTTP request containing 'email' and 'password'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the generated token, or an error message.
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

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

    /**
     * Logout the authenticated user by revoking all tokens.
     *
     * @param Request $request The HTTP request containing the authenticated user.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function logout(Request $request)
    {
        try {
            if ($request->user()->tokens()->delete()) {
                return response()->json(['message' => 'Logout realizado com sucesso'], 200);
            }

            return response()->json(['message' => 'Erro ao realizar logout'], 500);

        } catch (Exception $e) {
            Log::error('Erro ao realizar logout: ' . $e->getMessage());

            return response()->json(['message' => 'Erro ao realizar logout'], 500);
        }
    }
}
