<?php

namespace Tests\Unit\Services;

use App\Services\Admin\AdminUserService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\DTOs\Admin\UserDTO;
use App\Models\User;
use Mockery;

test('storeUser calls repository with correct data', function () {
    $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

    $dto = new UserDTO('John Doe', 'john@example.com', 'password', 'user');

    $repositoryMock->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($data) {
            return $data instanceof UserDTO && $data->email === 'john@example.com';
        }))
        ->andReturn(new User());

    // 4. Action
    $service = new AdminUserService($repositoryMock);
    $service->storeUser($dto);
});
