<?php

namespace App\Domain\Users\DTOs;

readonly class UpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password,
    ) {}
}