<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function paket()
    {
        return view('admin.paket.index');
    }

    public function transaksi()
    {
        return view('admin.transaksi.index');
    }

    public function daftarTransaksi()
    {
        return view('admin.daftar-transaksi.index');
    }

    public function laporanTransaksi()
    {
        return view('admin.laporan-transaksi.index');
    }

    public function logAktivitas()
    {
        return view('admin.log-aktivitas.index');
    }
}
