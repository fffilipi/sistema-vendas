<?php

namespace App\Services\Auth;

use App\Repositories\Contracts\TokenRepositoryInterface;
use App\DTO\Auth\LogoutUserDto;

class LogoutUserService
{
    private TokenRepositoryInterface $logoutRepository;

    /**
     * LogoutUserService constructor.
     *
     * @param TokenRepositoryInterface $logoutRepository The repository responsible for managing user tokens.
     */
    public function __construct(TokenRepositoryInterface $logoutRepository)
    {
        $this->logoutRepository = $logoutRepository;
    }

    /**
     * Logout the authenticated user by revoking all tokens.
     *
     * @param LogoutUserDto $data The DTO containing the authenticated user instance.
     * @return bool True if the tokens were successfully revoked, false otherwise.
     */
    public function logout(LogoutUserDto $data): bool
    {
        return $this->logoutRepository->deleteUserTokens($data->user);
    }
}