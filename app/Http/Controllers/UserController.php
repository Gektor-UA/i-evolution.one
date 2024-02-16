<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
//        $users = User::where('is_ambassador', 1)->get();
//        $users = User::where('is_ambassador', 0)->get();
        return view('index', ['users' => $users]);
    }

    public function create()
    {
        $user = new User();
        return view('register', compact('user'));
    }

    public function isAmbassador($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return false;
        }
        return $user->isAmbassador();
    }
}
