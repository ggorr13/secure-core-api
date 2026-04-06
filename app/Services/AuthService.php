<?php

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private AuthRepositoryInterface $authRepository
    ) {}

    /**
     * Authenticate user and return token.
     * @throws ValidationException
     */
    public function login(LoginDTO $dto): array
    {
        $user = $this->authRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        return [
            'user'  => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];
    }

    public function register(RegisterDTO $dto): array
    {
        $user = $this->authRepository->create($dto);

        $user->roles()->syncWithoutDetaching([2]);

        return [
            'user'  => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}
