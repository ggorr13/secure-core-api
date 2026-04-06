<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\DTOs\Auth\RegisterDTO;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{
    public function create(RegisterDTO $data): User
    {
        return DB::transaction(function () use ($data) {
            /** @var User $user */
            $user = User::query()->create([
                'name'     => $data->name,
                'email'    => $data->email,
                'password' => Hash::make($data->password),
            ]);

            return $user;
        });
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
