<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiService
{
    private $transaksiRepository;

    public function __construct(TransaksiRepositoryInterface $transaksiRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
    }

    public function getAllData()
    {
        return $this->transaksiRepository->getAllTransactionData();
    }

    private function generateCode()
    {
        // $latest = $this->transaksiRepository->getLatestTransaksiData();
        // $noUrut = ($latest == null) ? "001" : (int)Str::substr($latest->kode_invoice, 8, Str::length($latest->kode_invoice)) + 1;
        // $noUrutAfter = (Str::length($noUrut) < 3) ? str_repeat('0', 3 - Str::length($noUrut)) . $noUrut : $noUrut;
        // $kodeInvoice = 'INV' . date('Ym') . $noUrutAfter;

        // return $kodeInvoice;
        $latest = $this->transaksiRepository->getLatestTransaksiData();
        $format = "INV" . date('Ym');
        $noUrut = (is_null($latest)) ? "001" : (int)Str::substr($latest->kode_invoice, Str::length($format) + 1, Str::length($latest->kode_invoice)) + 1;
        $noUrutAfter = (Str::length($noUrut) < 3) ? str_repeat('0', 3 - Str::length($noUrut)) . $noUrut : $noUrut;
        $kodeInvoice = $format . $noUrutAfter;

        return $kodeInvoice;
    }

    public function storeTransaksi($payload)
    {
        $array = [
            'outlet_id' => Auth::user()->outlet_id,
            'kode_invoice' => $this->generateCode(),
            'member_id' => $payload['member_id'],
            'tgl_bayar' => date('Y-m-d', strtotime($payload['tgl_bayar'])),
            'batas_waktu' => date('Y-m-d', strtotime($payload['batas_waktu'])),
            'metode_pembayaran' => $payload['metode_pembayaran'],
            'status_transaksi' => $payload['status_transaksi'],
            'status_pembayaran' => (int)$payload['total_pembayaran'] - (int)$payload['total_bayar'] <= 0 ? 'lunas' : 'belum lunas',
            'user_id' => Auth::user()->id
        ];
        return $this->transaksiRepository->createTransaksi($array);
    }

    public function storePembayaran($payload, $transaksiID)
    {
        $array = [
            'transaksi_id' => $transaksiID,
            'biaya_tambahan' => $payload['biaya_tambahan'],
            'diskon' => $payload['diskon'],
            'pajak' => $payload['pajak'],
            'total_pembayaran' => $payload['total_pembayaran'],
            'total_bayar' => $payload['total_bayar'],
        ];
        return $this->transaksiRepository->createPembayaran($array);
    }

    public function storeDetailTransaksi($payload, $transaksiID)
    {
        $array = [];
        for($i = 0; $i < count($payload); $i++) {
            $paket = [
                'transaksi_id' => $transaksiID,
                'paket_id' => $payload[$i]['id'],
                'qty' => $payload[$i]['qty'],
                'ket' => 'Tidak Ada',
            ];
            array_push($array, $this->transaksiRepository->createDetailTransaksi($paket));
        }
        return $array;
    }

    public function updateTransaksi($payload, $transaksiID)
    {
        $array = [
            'status_transaksi' => $payload['status_transaksi'],
            'status_pembayaran' => 'lunas',
        ];
        return $this->transaksiRepository->updateTransaksi($array, $transaksiID);
    }
}

