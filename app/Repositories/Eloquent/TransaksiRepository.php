<?php

namespace App\Repositories\Eloquent;

use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;

class TransaksiRepository implements TransaksiRepositoryInterface
{
    private $transaksi;
    private $pembayaran;
    private $detailTransaksi;

    public function __construct(Transaksi $transaksi, Pembayaran $pembayaran, DetailTransaksi $detailTransaksi)
    {
        $this->transaksi = $transaksi;
        $this->pembayaran = $pembayaran;
        $this->detailTransaksi = $detailTransaksi;
    }

    public function getAllTransactionData()
    {
        return $this->transaksi->with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->get();
    }

    public function createTransaksi(array $payload)
    {
        return $this->transaksi->create($payload);
    }

    public function createPembayaran(array $payload)
    {
        return $this->pembayaran->create($payload);
    }

    public function createDetailTransaksi(array $payload)
    {
        return $this->detailTransaksi->create($payload);
    }

    public function getLatestTransaksiData()
    {
        return $this->transaksi->latest()->first();
    }

    public function updateTransaksi(array $payload, $id)
    {
        return $this->transaksi->findOrFail($id)->update($payload);
    }

    public function updatePembayaran(array $payload, $id)
    {
        return $this->pembayaran->where('transaksi_id', $id)->update($payload);
    }

    public function getNonCashData()
    {
        return $this->transaksi->with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->where('metode_pembayaran', '!=', 'cash')->where('status_pembayaran', 'belum lunas')->get();
    }

    public function findTransaksiByInvoice(string $noInvoice)
    {
        return $this->transaksi->with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->where('kode_invoice', $noInvoice)->first();
    }
}
