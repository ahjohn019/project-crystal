<?php

namespace App\Http\Services;

use App\Models\User;
use App\Library\RoleTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBroker;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Swift_TransportException;


class AuthService
{
    public static function login(array $payload)
    {
        if (Auth::attempt($payload['credentials'])) {
            $user = auth()->user();

            $token = $user->createToken($payload['device_name']);

            return $token;
        }

        throw new BadRequestException('The provided credentials are incorrect.');
    }

    public static function logout()
    {
        if (method_exists(auth()->user()->currentAccessToken(), 'delete')) {
            return auth()->user()->currentAccessToken()->delete();
        }

        auth()->guard('web')->logout();
    }

    public static function createUser(array $payload)
    {
        return DB::transaction(function () use ($payload) {
            $user = new User();
            $user = $user->create([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => isset($payload['password']) ? bcrypt($payload['password']) : '1111aaaa',
                'email_verified_at' => $payload['email_verified_at'] ?? null
            ]);

            $user->assignRole($payload['role'] ?? RoleTag::USER);

            return $user;
        });
    }

    public static function resetPassword(array $request)
    {
        $result = Password::broker()->reset($request, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->email_verified_at = now();
            $user->save();
        });

        switch ($result) {
            case PasswordBroker::INVALID_TOKEN:
                throw new BadRequestException('The token is invalid');
                break;
            case PasswordBroker::INVALID_USER:
                throw new BadRequestException('User is invalid');
                break;
            default:
                break;
        }

        return $result;
    }

    public static function forgotPassword(String $email)
    {
        try {
            Password::broker()->sendResetLink(['email' => $email]);
        } catch (Swift_TransportException $e) {
            Log::alert($e);
            throw new BadRequestException('Email failed to send');
        }
        return $email;
    }

    public static function updateUser(User $user, array $payload): User
    {
        $result = DB::transaction(function () use ($user, $payload) {
            $user->update([
                'name' => $payload['name'] ?? $user->name,
                'email' => $payload['email'] ?? $user->email,
                'password' => $payload['password'] ?? $user->password,
            ]);

            return $user;
        });

        return $result;
    }
}
