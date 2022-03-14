<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{
    public $example = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'jk' => 'L',
        ],
        [
            'id' => 2,
            'name' => 'Jane Doe',
            'jk' => 'P',
        ],
        [
            'id' => 3,
            'name' => 'Jane Doe',
            'jk' => 'P',
        ],
    ];

    public function test()
    {
        $users = User::all();
        $view = View::make('mail.index', compact('users'))->render();
        return response()->json([
            'html' => $view
        ]);
    }

    public function test2()
    {
        return view('test.test-1');
    }
}
