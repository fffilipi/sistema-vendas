<?php

namespace App\Services\Comission;

use App\Dto\Auth\LoginUserDto;
use App\Repositories\Contracts\Auth\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;

class ResendReportCommissionService
{
    /**
     * LoginUserService constructor.
     *
     * @param UserRepositoryInterface $userRepository The user repository instance for user-related operations.
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Authenticate a user and generate an access token.
     *
     * @param LoginUserDto $credentials The login credentials, typically containing 'email' and 'password'.
     * @return string The generated plain text token for the authenticated user.
     * 
     * @throws Exception  If the credentials are invalid or if there is an error during token generation.
     */
    public function login(LoginUserDto $credentials): string
    {
        $user = $this->userRepository->findByEmail($credentials->email);

        if (!$user || !Hash::check($credentials->password, $user->password)) {
            throw new Exception('Credenciais inválidas', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        if (!$token) {
            throw new Exception('Erro ao criar token', 500);
        }

        return $token;
    }
}
