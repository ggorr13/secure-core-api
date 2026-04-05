<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\MessageResource;
use App\Services\Admin\AdminUserService;
use App\DTOs\Admin\UserDTO;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth:sanctum')]
#[Middleware('role:admin')]
class UserController extends Controller
{
    public function __construct(
        private AdminUserService $adminService
    ) {

    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->adminService->listUsers();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $dto = UserDTO::fromRequest($request->validated());
        $user = $this->adminService->storeUser($dto);

        return new UserResource($user);
    }

    public function show(int $id): UserResource
    {
        $user = $this->adminService->getUser($id);
        return new UserResource($user);
    }


    public function update(UpdateUserRequest $request, int $id): UserResource
    {
        $dto = UserDTO::fromRequest($request->validated());
        $user = $this->adminService->updateUser($id, $dto);

        return new UserResource($user);
    }

    public function makeAdmin(int $id): UserResource
    {
        $user = $this->adminService->makeAdmin($id);
        return new UserResource($user);
    }

    public function removeAdmin(int $id): UserResource
    {
        $user = $this->adminService->removeAdmin($id);
        return new UserResource($user);
    }

    public function destroy(int $id): MessageResource
    {
        $this->adminService->deleteUser($id);

        return new MessageResource("User with ID #{$id} has been permanently deleted.");
    }
}
