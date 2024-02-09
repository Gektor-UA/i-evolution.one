<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', ['users' => $users]);
    }

    public function create()
    {
        $user = new User(); // Створюємо новий екземпляр моделі User
        return view('register', compact('user')); // Передаємо створений екземпляр моделі у представлення
    }
}
