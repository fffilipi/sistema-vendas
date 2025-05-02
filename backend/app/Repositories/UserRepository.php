<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array $data The data to create the user with.
     * @return User|null The user instance if found, or null if not.
     */
    public function create(array $data): ?User
    {
        return User::create($data);
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return User|null The user instance if found, or null if not.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
