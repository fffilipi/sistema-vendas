<?php
namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;
use App\Dto\Auth\RegisterUserDto;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;

class RegisterUserService
{
    /**
     * RegisterUserService constructor.
     *
     * @param UserRepositoryInterface $userRepository The repository responsible for managing user data.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new user and return the data with token.
     *
     * @param RegisterUserDTO $data The user data, including 'name', 'email', and 'password'.
     * @return array{user: \App\Models\User, token: string} An array containing the created user and the generated authentication token.
     * 
     * @throws Exception If there is an error during user creation or token generation.
     */
    public function execute(RegisterUserDTO $data): array
    {
        $user = $this->userRepository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        if (!$user) {
            throw new Exception('Erro ao criar o usuário', 500);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        if (!$token) {
            throw new Exception('Erro ao criar token', 500);
        }

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
