<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::firstWhere([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if (!$user) return View::make('login');
        $request->session()->put('user.id', $user->id);
        $request->session()->put('user.email', $user->email);
        $request->session()->put('user.name', $user->name);
        $request->session()->put('user.role', $user->role);

        if ($user->role == 'admin') return redirect('/users');
        return redirect('/tasks');
    }


    public function register(Request $request)
    {
        User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        return View::make('login');
    }


    public function changeRole(Request $request, $id, $role)
    {
        $role = $request->session()->get('user.role');
        if ($role != 'admin') redirect('/tasks');

        $user = User::where('id', $id)->first();
        $user->role = $role;
        $user->save();
        return redirect('/users');
    }

    public function show(Request $request)
    {
        $role = $request->session()->get('user.role');
        if ($role != 'admin') return redirect('/tasks');

        $users = User::all();
        return View::make('users', [
            'users' => $users
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user.id');
        $request->session()->forget('user.name');
        $request->session()->forget('user.role');
        $request->session()->forget('user.email');
        return redirect('/login');
    }
}
