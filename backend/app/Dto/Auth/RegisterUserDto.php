<?php

namespace App\Dto\Auth;

class RegisterUserDto
{
    /**
     * RegisterUserDto constructor.
     *
     * @param string $name The name of the user.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    /**
     * Create a DTO instance from an array.
     *
     * @param array $data The data array containing 'name', 'email', and 'password'.
     * @return self A new instance of RegisterUserDto.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password']
        );
    }
}
