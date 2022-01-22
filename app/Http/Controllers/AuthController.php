<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authenticate;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(Authenticate $request)
    {
        $result = $this->authService->credentialsCheck($request);
        return $result;
    }
}
