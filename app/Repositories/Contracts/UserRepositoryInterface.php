<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAll(): Collection;
    public function paginate(
        int $perPage = 10,
        string $search = '',
        string $sortCol = 'created_at',
        string $sortDir = 'desc'
        ): LengthAwarePaginator;
    public function find(int $id): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
    public function bulkDelete(array $ids): bool;
}