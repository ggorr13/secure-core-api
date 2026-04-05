<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'user']);
});

test('it registers a new user and returns 201 status via resource', function () {
    $payload = [
        'name' => 'Gor Developer',
        'email' => 'gor@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/register', $payload);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'user' => ['id', 'name', 'email', 'roles'],
                'auth' => ['token', 'type']
            ]
        ]);

    // Use $this to access Laravel's database assertions
    $this->assertDatabaseHas('users', ['email' => 'gor@example.com']);
});

test('it logs in an existing user with valid credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('secret-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'secret-password',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.user.email', 'test@example.com');
});

test('it returns 422 for incorrect login credentials', function () {
    User::factory()->create(['email' => 'user@test.com']);

    $response = $this->postJson('/api/login', [
        'email' => 'user@test.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'status' => 'error',
            'message' => 'Validation Failed'
        ]);
});

test('it logs out and returns a consistent message structure', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'status'  => 'success',
                'message' => 'User logged out successfully.'
            ]
        ]);

    // Verify token is revoked
    expect($user->fresh()->tokens)->toBeEmpty();
});
