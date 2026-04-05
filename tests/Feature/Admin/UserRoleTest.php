<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->adminRole = Role::firstOrCreate(['name' => 'admin']);
    $this->userRole = Role::firstOrCreate(['name' => 'user']);

    $this->admin = User::factory()->create();
    $this->admin->roles()->attach($this->adminRole);
});

test('admin cannot remove their own admin role', function () {
    $response = $this->actingAs($this->admin)
        ->postJson("/api/admin/users/{$this->admin->id}/remove-admin");

    $response->assertStatus(403);
});

test('admin can promote a regular user to admin', function () {
    $user = User::factory()->create();
    $user->roles()->attach($this->userRole);

    $response = $this->actingAs($this->admin)
        ->postJson("/api/admin/users/{$user->id}/make-admin");

    $response->assertStatus(200);

    expect($user->refresh()->hasRole('admin'))->toBeTrue();
});
