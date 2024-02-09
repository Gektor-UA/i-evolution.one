<?php

namespace App\Http\Controllers;

use App\Models\UserSecond;
use Illuminate\Http\Request;

class SecondUserController extends Controller
{
    public function index()
    {
        $users = UserSecond::all(); // Отримання всіх користувачів з таблиці другої бази даних
        return view('index', compact('users'));
    }
}
