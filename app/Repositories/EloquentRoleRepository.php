<?php

namespace App\Repositories;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    public function getAll(): Collection
    {
        return Role::with('permissions')->latest()->get();
    }

    protected function buildQuery(string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Builder
    {
        $query = Role::with('permissions');

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });

        if (in_array($sortCol, ['id', 'name', 'created_at', 'updated_at'])) {
            $query->orderBy($sortCol, $sortDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function paginate(int $perPage = 10, string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): LengthAwarePaginator
    {
        return $this->buildQuery($search, $sortCol, $sortDir)->paginate($perPage);
    }

    public function find(int $id): ?Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function bulkDelete(array $ids): bool
    {
        return Role::whereIn('id', $ids)->delete();
    }

    public function getForExport(array $selectedIds = [], string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Collection
    {
        if (!empty($selectedIds)) {
            return Role::with('permissions')
                ->whereIn('id', $selectedIds)
                ->orderBy($sortCol, $sortDir)
                ->get();
        }
        
        return $this->buildQuery($search, $sortCol, $sortDir)->get();
    }
}