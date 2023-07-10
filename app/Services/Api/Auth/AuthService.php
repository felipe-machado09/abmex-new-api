<?php

namespace App\Services\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Password};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(LoginRequest $request): User
    {
        $request->authenticate();

        $user = $this->findUserForCreateToken($request->email);

        $user->token = $this->createApiToken($user);

        return $user;
    }

    public function newPassword(Request $request): array
    {
        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return [
            'message' => 'Password changed successfully',
            'status'  => true,
        ];
    }

    public function createApiToken(User $user): string
    {
        return $user->createToken($user->email . '-api')->plainTextToken;
    }

    public function forgotPassword(Request $request): array
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return [
            'message' => 'Reset password email sent successfully',
            'status'  => true,
        ];
    }

    private function findUserForCreateToken(string $email): User
    {
        return User::query()->whereEmail($email)->firstOrFail();
    }
}
