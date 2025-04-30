<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
                Log::warning('Falha ao criar usuário - dados: ' . json_encode($request->only(['name', 'email'])));
                throw new \Exception('Erro ao registrar usuário');
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao registrar o usuário. Tente novamente mais tarde.');
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
                return ResponseHelper::error('Credenciais inválidas.', 401);
            }

            $user = Auth::guard('web')->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success('Login realizado com sucesso.', [
                'token' => $token
            ]);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao realizar login. Tente novamente mais tarde.');
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
                return ResponseHelper::success('Logout realizado com sucesso');
            }
    
            throw new \Exception('Falha ao deletar tokens');
    
        } catch (\Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao realizar logout. Tente novamente mais tarde.');
        }
    }
}
