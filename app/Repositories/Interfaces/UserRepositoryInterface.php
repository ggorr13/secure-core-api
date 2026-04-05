<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): User;
    public function create(array $data): User;
    public function update(int $id, array $data): User;
    public function updateRole(int $id, string $roleName): User;
    public function delete(int $id): bool;
}
