<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function getAll(): Collection;
    public function paginate(
        int $perPage = 10,
        string $search = '',
        string $sortCol = 'created_at',
        string $sortDir = 'desc'
        ): LengthAwarePaginator;
    public function find(int $id): ?Role;
    public function create(array $data): Role;
    public function update(Role $role, array $data): bool;
    public function delete(Role $role): bool;
    public function bulkDelete(array $ids): bool;
    public function getForExport(array $selectedIds = [], string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Collection;
}