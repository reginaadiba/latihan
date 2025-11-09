<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(Request $request)
    {
        $name = $request->name;
        $users = User::with('phone')->get();
        // return $users;
        return view('users', ['users' => $users, 'name' => $name]);
    }
}
