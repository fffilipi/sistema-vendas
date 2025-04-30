<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository The user repository instance for user-related operations.
     */
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    /**
     * Authenticate a user and generate an access token.
     *
     * @param array $credentials The login credentials, typically containing 'email' and 'password'.
     * @return string The generated plain text token for the authenticated user.
     */
    public function login(array $credentials): string
    {
        if (!Auth::guard('web')->attempt($credentials)) {
            return ResponseHelper::error('Credenciais inválidas.', 401);
        }

        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user) {
            return ResponseHelper::error();
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
