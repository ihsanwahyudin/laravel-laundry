<?php

namespace App\Repositories\Eloquent;

use App\Models\DetailPembayaran;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;

class TransaksiRepository implements TransaksiRepositoryInterface
{
    private $transaksi;
    private $pembayaran;
    private $detailTransaksi;
    private $detailPembayaran;

    public function __construct(Transaksi $transaksi, Pembayaran $pembayaran, DetailTransaksi $detailTransaksi, DetailPembayaran $detailPembayaran)
    {
        $this->transaksi = $transaksi;
        $this->pembayaran = $pembayaran;
        $this->detailTransaksi = $detailTransaksi;
        $this->detailPembayaran = $detailPembayaran;
    }

    public function getAllTransactionData()
    {
        return $this->transaksi->with(['pembayaran' => function($q) {
            $q->with('detailPembayaran')->get();
        }, 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->get();
    }

    public function filterTransactionDataByDate($startDate, $endDate)
    {
        return $this->transaksi->with(['pembayaran' => function($q) {
            $q->with('detailPembayaran')->get();
        }, 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function createTransaksi(array $payload)
    {
        return $this->transaksi->create($payload);
    }

    public function createPembayaran(array $payload)
    {
        return $this->pembayaran->create($payload);
    }

    public function createDetailPembayaran(array $payload)
    {
        return $this->detailPembayaran->create($payload);
    }

    public function createDetailTransaksi(array $payload)
    {
        return $this->detailTransaksi->create($payload);
    }

    public function getLatestTransaksiData()
    {
        return $this->transaksi->orderBy('kode_invoice', 'DESC')->first();
    }

    public function updateTransaksi(array $payload, $id)
    {
        $data = $this->transaksi->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function updatePembayaran(array $payload, $id)
    {
        $data = $this->pembayaran->where('transaksi_id', $id)->first();
        $data->update($payload);
        return $data;
    }

    public function getNonCashData()
    {
        return $this->transaksi->with(['pembayaran' => function($q) {
            $q->with('detailPembayaran')->get();
        }, 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->where('metode_pembayaran', '!=', 'cash')->where('status_pembayaran', 'belum lunas')->get();
    }

    public function findTransaksiByInvoice(string $noInvoice)
    {
        return $this->transaksi->with(['pembayaran' => function($q) {
            $q->with('detailPembayaran')->get();
        }, 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->where('kode_invoice', $noInvoice)->first();
    }

    public function filterDataByStatusTransaksi(string $type, bool $hasPenjemputan) : object
    {
        return $this->transaksi->with(['pembayaran' => function($q) {
            $q->with('detailPembayaran')->get();
        }, 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->where('status_transaksi', $type)->get();
    }

    public function doesntHavePenjemputan(): ?object
    {
        // if($statusPenjemputan === 'exists') {
        //     return $this->transaksi->with(['detailTransaksi' => function($q) {
        //         $q->with('paket');
        //     }, 'pembayaran', 'member'])->whereHas('penjemputan')->where('status_transaksi', 'selesai')->get();
        // } else {
            return $this->transaksi->with(['pembayaran' => function($q) {
                $q->with('detailPembayaran')->get();
            }, 'member', 'detailTransaksi' => function($q) {
                $q->with('paket')->get();
            }])->where('status_transaksi', 'selesai')->whereDoesntHave('penjemputan')->get();
        // }
    }
}
