<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Find a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return \App\Models\User|null The user instance if found, or null if not.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
