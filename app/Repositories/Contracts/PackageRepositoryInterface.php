<?php

namespace App\Repositories\Contracts;

use App\Models\Packages;
use Illuminate\Database\Eloquent\Collection;

interface PackageRepositoryInterface
{
    public function getAll(): Collection;
    public function find(int $id): ?Packages;
    public function create(array $data): Packages;
    public function update(Packages $package, array $data): bool;
    public function delete(Packages $package): bool;
}