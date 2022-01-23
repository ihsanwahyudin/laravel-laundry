<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct()
    {
        //
    }

    public function credentialsCheck($payload)
    {
        if(Auth::attempt($payload->only(['email', 'password']), (boolean)$payload->remember)) {
            $payload->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
