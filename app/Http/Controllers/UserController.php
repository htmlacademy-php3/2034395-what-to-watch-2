<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get(int $id): User
    {
        return new User();
    }

    public function change(string $email, string $password, string $passwordConfirmation, string $name, string $photoUrl): void
    {

    }
}
