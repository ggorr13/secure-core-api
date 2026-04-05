<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup roles and an admin user
    $this->adminRole = Role::firstOrCreate(['name' => 'admin']);
    $this->userRole = Role::firstOrCreate(['name' => 'user']);

    $this->admin = User::factory()->create();
    $this->admin->roles()->attach($this->adminRole);
});

test('admin can list all users', function () {
    User::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)
        ->getJson('/api/admin/users');

    $response->assertStatus(200)
        ->assertJsonCount(4, 'data'); // 3 factory users + 1 admin
});

test('admin cannot delete themselves due to Policy', function () {
    $response = $this->actingAs($this->admin)
        ->deleteJson("/api/admin/users/{$this->admin->id}");

    $response->assertForbidden();

    $response->assertJsonPath('message', 'Senior Rule: You cannot update or delete your own account.');
});

test('admin can update a regular user', function () {
    $targetUser = User::factory()->create();

    $updateData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'role' => 'admin'
    ];

    $response = $this->actingAs($this->admin)
        ->putJson("/api/admin/users/{$targetUser->id}", $updateData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
});
