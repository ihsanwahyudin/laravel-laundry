<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaksi;
use App\Repositories\Interfaces\Eloquent\LaporanRepositoryInterface;

class LaporanRepository implements LaporanRepositoryInterface
{
    private $transaksi;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function getLaporanTransaksi()
    {
        return $this->transaksi->with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->latest()->get();
    }

    public function getLaporanTransaksiBetweenDate($startDate, $endDate)
    {
        return $this->transaksi->with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->whereBetween('created_at', [$startDate, $endDate])->latest()->get();
    }

    public function getLaporanTransaksiPerOutlet()
    {
        return $this->transaksi->select('outlet_id', 'outlet_nama', 'outlet_alamat', 'outlet_telepon', 'outlet_email', 'outlet_website', 'outlet_logo', 'outlet_latitude', 'outlet_longitude', 'outlet_status', 'outlet_created_at', 'outlet_updated_at')->groupBy('outlet_id')->latest()->get();
    }

    public function getLaporanTransaksiPerKaryawan()
    {
        return $this->transaksi->select('karyawan_id', 'karyawan_nama', 'karyawan_alamat', 'karyawan_telepon', 'karyawan_email', 'karyawan_website', 'karyawan_logo', 'karyawan_latitude', 'karyawan_longitude', 'karyawan_status', 'karyawan_created_at', 'karyawan_updated_at')->groupBy('karyawan_id')->latest()->get();
    }

    public function getLaporanTransaksiPerMember()
    {
        return $this->transaksi->select('member_id', 'member_nama', 'member_alamat', 'member_telepon', 'member_email', 'member_website', 'member_logo', 'member_latitude', 'member_longitude', 'member_status', 'member_created_at', 'member_updated_at')->groupBy('member_id')->latest()->get();
    }

    public function getLaporanTransaksiPerPaket()
    {
        return $this->transaksi->select('paket_id', 'paket_nama', 'paket_harga', 'paket_diskon', 'paket_status', 'paket_created_at', 'paket_updated_at')->groupBy('paket_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulan()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun')->latest()->get();
    }

    public function getLaporanTransaksiPerTahun()
    {
        return $this->transaksi->selectRaw('YEAR(transaksi_tanggal) as tahun, COUNT(transaksi_id) as jumlah')->groupBy('tahun')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerTahun()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerOutlet()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'outlet_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerKaryawan()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, karyawan_id, karyawan_nama, karyawan_alamat, karyawan_telepon, karyawan_email, karyawan_website, karyawan_logo, karyawan_latitude, karyawan_longitude, karyawan_status, karyawan_created_at, karyawan_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'karyawan_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerMember()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, member_id, member_nama, member_alamat, member_telepon, member_email, member_website, member_logo, member_latitude, member_longitude, member_status, member_created_at, member_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'member_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerPaket()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, paket_id, paket_nama, paket_harga, paket_diskon, paket_status, paket_created_at, paket_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'paket_id')->latest()->get();
    }

    public function getLaporanTransaksiPerTahunPerOutlet()
    {
        return $this->transaksi->selectRaw('YEAR(transaksi_tanggal) as tahun, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('tahun', 'outlet_id')->latest()->get();
    }

    public function getLaporanTransaksiPerTahunPerKaryawan()
    {
        return $this->transaksi->selectRaw('YEAR(transaksi_tanggal) as tahun, karyawan_id, karyawan_nama, karyawan_alamat, karyawan_telepon, karyawan_email, karyawan_website, karyawan_logo, karyawan_latitude, karyawan_longitude, karyawan_status, karyawan_created_at, karyawan_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('tahun', 'karyawan_id')->latest()->get();
    }

    public function getLaporanTransaksiPerTahunPerMember()
    {
        return $this->transaksi->selectRaw('YEAR(transaksi_tanggal) as tahun, member_id, member_nama, member_alamat, member_telepon, member_email, member_website, member_logo, member_latitude, member_longitude, member_status, member_created_at, member_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('tahun', 'member_id')->latest()->get();
    }

    public function getLaporanTransaksiPerTahunPerPaket()
    {
        return $this->transaksi->selectRaw('YEAR(transaksi_tanggal) as tahun, paket_id, paket_nama, paket_harga, paket_diskon, paket_status, paket_created_at, paket_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('tahun', 'paket_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerOutletPerKaryawan()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, karyawan_id, karyawan_nama, karyawan_alamat, karyawan_telepon, karyawan_email, karyawan_website, karyawan_logo, karyawan_latitude, karyawan_longitude, karyawan_status, karyawan_created_at, karyawan_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'outlet_id', 'karyawan_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerOutletPerMember()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, member_id, member_nama, member_alamat, member_telepon, member_email, member_website, member_logo, member_latitude, member_longitude, member_status, member_created_at, member_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'outlet_id', 'member_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerOutletPerPaket()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, paket_id, paket_nama, paket_harga, paket_diskon, paket_status, paket_created_at, paket_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'outlet_id', 'paket_id')->latest()->get();
    }

    public function getLaporanTransaksiPerBulanPerKaryawanPerOutlet()
    {
        return $this->transaksi->selectRaw('MONTH(transaksi_tanggal) as bulan, YEAR(transaksi_tanggal) as tahun, karyawan_id, karyawan_nama, karyawan_alamat, karyawan_telepon, karyawan_email, karyawan_website, karyawan_logo, karyawan_latitude, karyawan_longitude, karyawan_status, karyawan_created_at, karyawan_updated_at, outlet_id, outlet_nama, outlet_alamat, outlet_telepon, outlet_email, outlet_website, outlet_logo, outlet_latitude, outlet_longitude, outlet_status, outlet_created_at, outlet_updated_at, COUNT(transaksi_id) as jumlah')->groupBy('bulan', 'tahun', 'karyawan_id', 'outlet_id')->latest()->get();
    }


}
