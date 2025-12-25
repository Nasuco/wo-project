<?php

namespace App\Services\Packages;

use App\Domain\Packages\DTOs\CreatePackageDTO;
use App\Domain\Packages\DTOs\UpdatePackageDTO;
use App\Repositories\Contracts\PackageRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PackageService
{
    public function __construct(
        protected PackageRepositoryInterface $packageRepository
    ) {}

    public function getAllPackages()
    {
        return $this->packageRepository->getAll();
    }

    public function getPaginatedPackages(int $perPage = 10, string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc')
    {
        return $this->packageRepository->paginate($perPage, $search, $sortCol, $sortDir);
    }

    public function getPackageById(int $id)
    {
        return $this->packageRepository->find($id);
    }

    public function createPackage(CreatePackageDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->packageRepository->create([
                'name' => $dto->name,
                'price' => $dto->price,
                'duration_days' => $dto->duration_days,
                'max_guests' => $dto->max_guests,
                'max_gallery' => $dto->max_gallery,
                'custom_domain' => $dto->custom_domain,
                'is_active' => $dto->is_active,
            ]);
        });
    }

    public function updatePackage(int $packageId, UpdatePackageDTO $dto)
    {
        $package = $this->packageRepository->find($packageId);

        return DB::transaction(function () use ($package, $dto) {
            $data = [
                'name' => $dto->name,
                'price' => $dto->price,
                'duration_days' => $dto->duration_days,
                'max_guests' => $dto->max_guests,
                'max_gallery' => $dto->max_gallery,
                'custom_domain' => $dto->custom_domain,
                'is_active' => $dto->is_active,
            ];

            return $this->packageRepository->update($package, $data);
        });
    }

    public function deletePackage(int $packageId)
    {
        $package = $this->packageRepository->find($packageId);
        return $this->packageRepository->delete($package);
    }
}