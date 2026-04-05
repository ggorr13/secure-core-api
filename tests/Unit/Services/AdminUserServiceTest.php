<?php


namespace Tests\Unit\Services;

use App\Services\Admin\AdminUserService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\DTOs\Admin\UserDTO;
use Mockery;

test('storeUser calls repository with correct data', function () {
    // 1. Mock the repository
    $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

    // 2. Prepare DTO
    $dto = new UserDTO('John Doe', 'john@example.com', 'password', 'user');

    // 3. Expectation
    $repositoryMock->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($data) {
            return $data['email'] === 'john@example.com';
        }));

    // 4. Action
    $service = new AdminUserService($repositoryMock);
    $service->storeUser($dto);
});
