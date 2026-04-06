<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\DTOs\Auth\RegisterDTO;

interface AuthRepositoryInterface
{
    public function create(RegisterDTO $data): User;

    public function findByEmail(string $email): ?User;
}
