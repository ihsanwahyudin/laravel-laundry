<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        if(Auth::attempt($payload->only(['username', 'password']), (boolean)$payload->remember)) {
            $payload->session()->regenerate();
            $context = ['user_id' => Auth::user()->id, 'user_name' => Auth::user()->name, 'IP_Address' => $this->getIPAddress()];
            Log::channel('activity')->info("Akses Login dengan IP Address \"" . $this->getIPAddress() . "\"", [
                'reference' => 'user',
                'status' => 'login',
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'data' => [...AllowedArrayLog::filter($context)]
            ]);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}
