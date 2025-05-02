<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dto\Auth\RegisterUserDto;
use App\Dto\Auth\LoginUserDto;
use App\Dto\Auth\LogoutUserDto;
use App\Helpers\ResponseHelper;
use App\Helpers\ErrorHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginUserService;
use App\Services\Auth\RegisterUserService;
use App\Services\Auth\LogoutUserService;
use Exception;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param LoginUserService $loginUserService The authentication service instance for user-related operations.
     * @param RegisterUserService $registerUserService The user registration service instance.
     * @param LogoutUserService $logoutUserService The user logout service instance.
     */
    public function __construct(
        private LoginUserService $loginUserService,
        private RegisterUserService $registerUserService,
        private LogoutUserService $logoutUserService
    ) {}

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request The HTTP request containing 'name', 'email', and 'password'.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created user and token, or an error message.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $data = RegisterUserDto::fromArray($request->validated());

            $user = $this->registerUserService->execute($data);

            return ResponseHelper::success('Usuario criado com sucesso.', ['user' => $user], 201);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao registrar o usuário. Tente novamente mais tarde.', $e->getCode());
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
            $data = LoginUserDto::fromArray($request->only(['email', 'password']));

            $token = $this->loginUserService->login($data);

            return ResponseHelper::success('Login realizado com sucesso.', ['token' => $token]);

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Erro ao realizar login.', $e->getCode());
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
            $data = LogoutUserDto::fromRequest($request);

            $logoutSuccess = $this->logoutUserService->logout($data);

            if (!$logoutSuccess) {
                throw new Exception('Falha ao deletar tokens', 500);
            }

            return ResponseHelper::success('Logout realizado com sucesso');

        } catch (Exception $e) {
            ErrorHelper::reportError($e);
            return ResponseHelper::error('Ocorreu um erro ao realizar logout. Tente novamente mais tarde.', $e->getCode());
        }
    }
}
