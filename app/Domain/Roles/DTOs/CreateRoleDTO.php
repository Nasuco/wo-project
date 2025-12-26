<?php

namespace App\Domain\Roles\DTOs;

readonly class CreateRoleDTO
{
    public function __construct(
        public string $name,
    ) {}
}