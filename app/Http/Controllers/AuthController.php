<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

class AuthController extends Controller
{
    public function getUser(Request $request) {
        return Auth::user();
    }
    public function showLoginForm(Request $request) {
        return view('auth.login');
    }
    public function showRegisterForm(Request $request) {
        return view('auth.register');
    }

    public function handleRegister(Request $request) {
        if ($request->conpassword == $request->password) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('login');
        } else {
            return redirect()->back()->withInput()->with('error','Password and confirm password not match!');
        }
    }
    public function handleLogin(Request $request) {
        $result = Auth::attempt(['email' => $request->email, 'password' => $request->password],true);
        if ($result) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error','Email/Password not correct!');
        }
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login');
    }
}
