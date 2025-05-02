<?php

namespace App\Dto\Auth;

class LoginUserDto
{
    /**
     * LoginDto constructor.
     *
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     */
    public function __construct(
        public string $email,
        public string $password
    ) {}

    /**
     * Create a DTO instance from an array.
     *
     * @param array $data The data array containing 'email' and 'password'.
     * @return self A new instance of LoginDto.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'],
            $data['password']
        );
    }
}
