<?php

namespace App\Domain\Roles\DTOs;

readonly class UpdateRoleDTO
{
    public function __construct(
        public string $name,
    ) {}
}