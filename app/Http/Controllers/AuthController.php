<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Support\Facades\Http;

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
        if (!$request->input('g-recaptcha-response')) {
            return redirect()->back()->with('error','You are a robot.');
        }
        $res = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => IpUtils::anonymize($request->ip())
        ]);
        if ($res->successful()) {
            $result = Auth::attempt(['email' => $request->email, 'password' => $request->password],true);
            if ($result) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error','Email/Password not correct!');
            }
        } else {
            return redirect()->back()->with('error','ReCAPTCHA is invalid!');
        }
        
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login');
    }
}
