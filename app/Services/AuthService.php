<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    private $logActivityService;

    public function __construct(LogActivityService $logActivityService)
    {
        $this->logActivityService = $logActivityService;
    }

    public function getIPAddress() {
        //whether ip is from the share internet
        if(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from the proxy
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from the remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function credentialsCheck($payload)
    {
        if(Auth::attempt($payload->only(['email', 'password']), (boolean)$payload->remember)) {
            $payload->session()->regenerate();
            $this->logActivityService->createLog('tb_user', ['id' => Auth::user()->id, 'name' => $this->getIPAddress()], 5);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
