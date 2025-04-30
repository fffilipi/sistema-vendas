<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\RegisterUserService;
use Exception;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService The authentication service instance for user-related operations.
     * @param RegisterUserService $registerUserService The user registration service instance.
     */
    public function __construct(
        private AuthService $authService,
        private RegisterUserService $registerUserService) {}

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request The HTTP request containing 'name', 'email', and 'password'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created user and token, or an error message.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->registerUserService->execute($request->validated());

            return ResponseHelper::success('Usuario criado com sucesso.', ['user' => $user], 201);

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
            $token = $this->authService->login($request->only(['email', 'password']));

            return ResponseHelper::success('Login realizado com sucesso.', ['token' => $token]);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao realizar login.');
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
