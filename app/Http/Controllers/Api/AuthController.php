<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\MessageResource;
use App\Services\AuthService;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request): LoginResource
    {
        $result = $this->authService->register(RegisterDTO::fromRequest($request));
        return new LoginResource($result);
    }

    public function login(LoginRequest $request): LoginResource
    {
        $result = $this->authService->login(LoginDTO::fromRequest($request));
        return new LoginResource($result);
    }

    public function logout(Request $request): MessageResource
    {
        $this->authService->logout($request->user());
        return new MessageResource('User logged out successfully.');
    }
}
