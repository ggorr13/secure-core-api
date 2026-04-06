<?php

namespace App\Services\Admin;

use App\Models\User;
use App\DTOs\Admin\UserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function listUsers(): LengthAwarePaginator
    {
        return $this->userRepository->getAllPaginated();
    }

    public function getUser(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function storeUser(UserDTO $dto): User
    {
        return $this->userRepository->create($dto);
    }

    public function updateUser(int $id, UserDTO $dto): User
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target);

        return $this->userRepository->update($id, $dto);
    }

    public function deleteUser(int $id): void
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target);

        $this->userRepository->delete($id);
    }

    public function makeAdmin(int $id): User
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target);

        return $this->userRepository->updateRole($id, 'admin');
    }

    public function removeAdmin(int $id): User
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target);

        return $this->userRepository->updateRole($id, 'user');
    }
}
