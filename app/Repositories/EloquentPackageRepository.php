<?php

namespace App\Repositories;
use App\Models\Packages;
use App\Repositories\Contracts\PackageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentPackageRepository implements PackageRepositoryInterface
{
    public function getAll(): Collection
    {
        return Packages::latest()->get();
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
}