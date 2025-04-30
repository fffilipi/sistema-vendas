<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;

class RegisterUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new user and return the data with token.
     *
     * @param array $data The user data, including 'name', 'email', and 'password'.
     * @return array{user: \App\Models\User, token: string}|\Illuminate\Http\JsonResponse The created user and token, or an error response.
     */
    public function execute(array $data): array|\Illuminate\Http\JsonResponse
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        if (!$user) {
            return ResponseHelper::error();
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
