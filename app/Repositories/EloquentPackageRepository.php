<?php

namespace App\Repositories;
use App\Models\Packages;
use App\Repositories\Contracts\PackageRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPackageRepository implements PackageRepositoryInterface
{
    public function getAll(): Collection
    {
        return Packages::latest()->get();
    }

    protected function buildQuery(string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Builder
    {
        return Packages::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy($sortCol, $sortDir);
    }

    public function paginate(int $perPage = 10, string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): LengthAwarePaginator
    {
        return $this->buildQuery($search, $sortCol, $sortDir)->paginate($perPage);
    }

    public function find(int $id): ?Packages
    {
        return Packages::findOrFail($id);
    }

    public function create(array $data): Packages
    {
        return Packages::create($data);
    }

    public function update(Packages $package, array $data): bool
    {
        return $package->update($data);
    }

    public function delete(Packages $package): bool
    {
        return $package->delete();
    }

    public function bulkDelete(array $ids): bool
    {
        return Packages::whereIn('id', $ids)->delete();
    }

    public function getForExport(array $selectedIds = [], string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc'): Collection
    {
        if (!empty($selectedIds)) {
            return Packages::whereIn('id', $selectedIds)
                ->orderBy($sortCol, $sortDir)
                ->get();
        }
        
        return $this->buildQuery($search, $sortCol, $sortDir)->get();
    }
}