<?php

namespace App\Repositories\Contracts;

use App\Models\Packages;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PackageRepositoryInterface
{
    public function getAll(): Collection;
    public function paginate(
        int $perPage = 10,
        string $search = '',
        string $sortCol = 'created_at',
        string $sortDir = 'desc'
        ): LengthAwarePaginator;
    public function find(int $id): ?Packages;
    public function create(array $data): Packages;
    public function update(Packages $package, array $data): bool;
    public function delete(Packages $package): bool;
    public function bulkDelete(array $ids): bool;
    public function getForExport(array $selectedIds = [], string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Collection;
}