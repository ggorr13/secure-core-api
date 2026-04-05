<?php

namespace App\Services\Admin;

use App\Models\User;
use App\DTOs\Admin\UserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserService
{
    public function __construct(private UserRepositoryInterface $userRepository) {
        //
    }

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
        return $this->userRepository->create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password,
            'role'     => $dto->role,
        ]);
    }

    public function updateUser(int $id, UserDTO $dto): User
    {
        $target = $this->userRepository->findById($id);

        // Gate will use UserPolicy@manage
        Gate::authorize('manage', $target);

        return $this->userRepository->update($id, [
            'name'  => $dto->name,
            'email' => $dto->email,
            'role'  => $dto->role,
        ]);
    }

    public function deleteUser(int $id): void
    {
        $target = $this->userRepository->findById($id);

        // Gate ensures admin cannot delete themselves
        Gate::authorize('manage', $target);

        $this->userRepository->delete($id);
    }

    public function makeAdmin(int $id): User
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target); // Policy will handle the logic

        return $this->userRepository->updateRole($id, 'admin');
    }

    public function removeAdmin(int $id): User
    {
        $target = $this->userRepository->findById($id);
        Gate::authorize('manage', $target); // Prevents admin from removing their own admin status

        return $this->userRepository->updateRole($id, 'user');
    }
}
