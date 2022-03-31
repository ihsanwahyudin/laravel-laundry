<?php

namespace App\Http\Controllers;

use App\Logging\LogReader;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    private $logActivityService;

    public function __construct(LogActivityService $logActivityService)
    {
        $this->logActivityService = $logActivityService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function home()
    {
        $data = LogReader::getLogs(['user_id' => Auth::user()->id]);
        return view('admin.home.index', $data);
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

    public function transaksiPembayaran()
    {
        return view('admin.transaksi-pembayaran.index');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function barangInventaris()
    {
        return view('admin.barang-inventaris.index');
    }

    public function kelolaGaji()
    {
        return view('admin.kelola-gaji.index');
    }

    public function penjemputan()
    {
        return view('admin.penjemputan.index');
    }

    public function simulasiTransaksi()
    {
        return view('admin.simulasi-transaksi.index');
    }

    public function barang()
    {
        return view('admin.barang.index');
    }

    public function simulasiPenjualan()
    {
        return view('admin.simulasi-penjualan.index');
    }

    public function templateCrud()
    {
        return view('admin.template-crud.index');
    }

    public function absensi()
    {
        return view('admin.absensi.index');
    }
}
