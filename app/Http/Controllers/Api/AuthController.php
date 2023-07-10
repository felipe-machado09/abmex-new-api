<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Api\Auth\AuthService;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Validation\{Rule, Rules};

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function login(LoginRequest $request): UserResource
    {
        return new UserResource($this->authService->login($request));
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        return response()->json($this->authService->newPassword($request));
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'email')],
        ]);

        return response()->json($this->authService->forgotPassword($request));
    }
}
