<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface TokenRepositoryInterface
{
    /**
     * Delete all tokens of the user.
     *
     * @param User $user
     * @return bool
     */
    public function deleteUserTokens(User $user): bool;
}
