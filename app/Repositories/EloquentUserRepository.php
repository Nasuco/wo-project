<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::latest()->get();
    }

    protected function buildQuery(string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Builder
    {
        return User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortCol, $sortDir);
    }

    public function paginate(int $perPage = 10, string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): LengthAwarePaginator
    {
        return $this->buildQuery($search, $sortCol, $sortDir)->paginate($perPage);
    }

    public function find(int $id): ?User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function bulkDelete(array $ids): bool
    {
        return User::whereIn('id', $ids)->delete();
    }

    public function getForExport(array $selectedIds = [], string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Collection
    {
        if (!empty($selectedIds)) {
            return User::whereIn('id', $selectedIds)
                ->orderBy($sortCol, $sortDir)
                ->get();
        }
        
        return $this->buildQuery($search, $sortCol, $sortDir)->get();
    }
}