<?php

namespace App\Services\Users;

use App\Domain\Users\DTOs\CreateUserDTO;
use App\Domain\Users\DTOs\UpdateUserDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(CreateUserDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->userRepository->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
            ]);
        });
    }

    public function updateUser(int $userId, UpdateUserDTO $dto)
    {
        $user = $this->userRepository->find($userId);

        return DB::transaction(function () use ($user, $dto) {
            $data = [
                'name' => $dto->name,
                'email' => $dto->email,
            ];

            if ($dto->password) {
                $data['password'] = Hash::make($dto->password);
            }

            return $this->userRepository->update($user, $data);
        });
    }

    public function deleteUser(int $userId)
    {
        $user = $this->userRepository->find($userId);
        return $this->userRepository->delete($user);
    }
}