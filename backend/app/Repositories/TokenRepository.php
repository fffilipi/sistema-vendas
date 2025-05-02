<?php

namespace App\Repositories;

use App\Repositories\Contracts\TokenRepositoryInterface;
use App\Models\User;

class TokenRepository implements TokenRepositoryInterface
{
    /**
     * Delete all tokens of the user.
     *
     * @param User $user
     * @return bool
     */
    public function deleteUserTokens(User $user): bool
    {
        return $user->tokens()->delete();
    }
}
