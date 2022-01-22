<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function home()
    {
        return view('admin.home.index');
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function outlet()
    {
        return view('admin.outlet.index');
    }

    public function member()
    {
        return view('admin.member.index');
    }

    public function karyawan()
    {
        return view('admin.karyawan.index');
    }
}
