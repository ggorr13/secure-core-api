<?php


namespace App\DTOs\Admin;

readonly class UserDTO
{
    public function __construct(
        public string  $name,
        public string  $email,
        public ?string $password = null,
        public ?string $role = 'user'
    )
    {
    }

    public static function fromRequest(array $validated): self
    {
        return new self(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'] ?? null,
            role: $validated['role'] ?? 'user'
        );
    }
}
