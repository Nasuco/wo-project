<?php

namespace App\Services\Roles;

use App\Domain\Roles\DTOs\CreateUserDTO;
use App\Domain\Roles\DTOs\UpdateUserDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoleService
{ 
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function getAllRoles()
    {
        return $this->roleRepository->getAll();
    }

    public function paginateRoles(int $perPage = 10, string $search = '', string $sortCol = 'created_at', string $sortDir = 'desc')
    {
        return $this->roleRepository->paginate($perPage, $search, $sortCol, $sortDir);
    }

    public function getRoleById(int $id)
    {
        return $this->roleRepository->find($id);
    }
}