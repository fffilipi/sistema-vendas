<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array $data The data to create the user with.
     * @return User|null The user instance if found, or null if not.
     */
    public function create(array $data): ?User;

    /**
     * Find a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return User|null The user instance if found, or null if not.
     */
    public function findByEmail(string $email): ?User;
}
