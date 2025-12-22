<?php

namespace App\Domain\Packages\DTOs;

readonly class CreatePackageDTO
{
    public function __construct(
        public string $name,
        public float $price,
        public int $duration_days,
        public int $max_guests,
        public int $max_gallery,
        public bool $custom_domain,
        public bool $is_active,
    ) {}
}