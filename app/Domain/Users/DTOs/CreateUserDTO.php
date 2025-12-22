<?php

namespace App\Domain\Users\DTOs;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}