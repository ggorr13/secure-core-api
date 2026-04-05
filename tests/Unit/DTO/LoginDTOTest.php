<?php

use App\DTOs\Auth\LoginDTO;
use App\Http\Requests\Auth\LoginRequest;

test('LoginDTO transforms request data correctly', function () {
    // Manually create a request to simulate the flow
    $request = new LoginRequest();
    $request->merge([
        'email' => 'gor@example.com',
        'password' => 'password123'
    ]);

    // Note: In a real test, we assume the validation passed
    $dto = new LoginDTO(
        email: $request->input('email'),
        password: $request->input('password')
    );

    expect($dto->email)->toBe('gor@example.com')
        ->and($dto->password)->toBe('password123');
});
