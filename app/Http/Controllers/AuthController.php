<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(
        string $email,
        string $password,
        string $passwordConfirmation,
        string $name,
        string $photoUrl
    ): string
    {
        return '';
    }

    public function login(string $email, string $password): string
    {
        return '';
    }

    public function logout(): void
    {

    }
}
