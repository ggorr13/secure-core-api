<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()->with('roles')->paginate($perPage);
    }

    public function findById(int $id): User
    {
        return User::query()->with('roles')->findOrFail($id);
    }

    public function create(array $data): User
    {
        // Using transaction because we have multiple queries (User insert + Role attach)
        return DB::transaction(function () use ($data) {
            $user = User::query()->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Ensure the role exists before attaching
            $role = Role::query()->where('name', $data['role'] ?? 'user')->firstOrFail();
            $user->roles()->attach($role);

            return $user;
        });
    }

    public function update(int $id, array $data): User
    {
        // Using transaction to ensure data integrity during multi-table updates
        return DB::transaction(function () use ($id, $data) {
            $user = $this->findById($id);

            // Strict mapping: Only allow name and email updates via fill
            $user->fill(collect($data)->only(['name', 'email'])->toArray());

            // Handle password hashing if a new password is provided
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            // Synchronize roles: sync() removes old roles and adds the new one
            if (isset($data['role'])) {
                $role = Role::query()->where('name', $data['role'])->firstOrFail();
                $user->roles()->sync([$role->id]);
            }

            return $user->refresh();
        });
    }

    public function updateRole(int $id, string $roleName): User
    {
        return DB::transaction(function () use ($id, $roleName) {
            $user = $this->findById($id);
            $role = Role::query()->where('name', $roleName)->firstOrFail();

            // sync() removes all current roles and sets only this one
            $user->roles()->sync([$role->id]);

            return $user->refresh();
        });
    }

    public function delete(int $id): bool
    {
        return User::destroy($id);
    }
}
