<?php

namespace App\Dto\Auth;

use App\Models\User;
use Illuminate\Http\Request;

class LogoutUserDto
{
    /**
     * LoginUserDto constructor.
     *
     * @param User $user The authenticated user instance.
     */
    public function __construct(
        public readonly User $user
    ) {}

    /**
     * Create a DTO instance from an HTTP request.
     *
     * @param Request $request The HTTP request containing the authenticated user.
     * @return self A new instance of LoginUserDto.
     */
    public static function fromRequest(Request $request): self
    {
        return new self($request->user());
    }
}
