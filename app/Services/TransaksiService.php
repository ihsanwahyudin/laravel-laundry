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

    public function getNonCashData()
    {
        return $this->transaksiRepository->getNonCashData();
    }

    private function generateCode()
    {
        $latest = $this->transaksiRepository->getLatestTransaksiData();
        $format = "INV" . date('Ym');
        $noUrut = (is_null($latest)) ? "001" : (int)Str::substr($latest->kode_invoice, Str::length($format) + 1, Str::length($latest->kode_invoice)) + 1;
        $noUrutAfter = (Str::length($noUrut) < 3) ? str_repeat('0', 3 - Str::length($noUrut)) . $noUrut : $noUrut;
        $kodeInvoice = $format . $noUrutAfter;

        return $kodeInvoice;
    }

    public function storeTransaksi($payload)
    {
        $data = [
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
        return $this->transaksiRepository->createTransaksi($data)->toArray();
    }

    public function storePembayaran($payload, $transaksiID)
    {
        $data = [
            'transaksi_id' => $transaksiID,
            'biaya_tambahan' => $payload['biaya_tambahan'],
            'diskon' => $payload['diskon'],
            'pajak' => $payload['pajak'],
            'total_pembayaran' => $payload['total_pembayaran'],
        ];
        return $this->transaksiRepository->createPembayaran($data)->toArray();
    }

    public function storeDetailPembayaran($payload, $pembayaranID)
    {
        $data = [
            'pembayaran_id' => $pembayaranID,
            'total_bayar' => $payload['total_bayar'],
        ];
        return $this->transaksiRepository->createDetailPembayaran($data)->toArray();
    }

    public function storeDetailTransaksi($payload, $transaksiID)
    {
        $data = [];
        for($i = 0; $i < count($payload); $i++) {
            $paket = [
                'transaksi_id' => $transaksiID,
                'paket_id' => $payload[$i]['id'],
                'qty' => $payload[$i]['qty'],
                'harga' => $payload[$i]['harga'],
                'keterangan' => $payload[$i]['ket'],
            ];
            array_push($data, $this->transaksiRepository->createDetailTransaksi($paket)->toArray());
        }
        return $data;
    }

    public function updateTransaksi($payload, $transaksiID)
    {
        $data = [
            'status_pembayaran' => $payload['pembayaran']['sisa_pembayaran'] <= 0 ? 'lunas' : 'belum lunas',
        ];
        return $this->transaksiRepository->updateTransaksi($data, $transaksiID);
    }

    public function updatePembayaran($payload, $transaksiID)
    {
        $data = [
            'biaya_tambahan' => $payload['biaya_tambahan'],
            'diskon' => $payload['diskon'],
            'total_pembayaran' => $payload['total_pembayaran'],
        ];

        return $this->transaksiRepository->updatePembayaran($data, $transaksiID);
    }

    public function updateStatusTransaksi($payload)
    {
        $data = [];
        foreach($payload['data_transaksi'] as $item) {
            $data = [
                'status_transaksi' => $payload['status_transaksi'],
            ];
            array_push($data, $this->transaksiRepository->updateTransaksi($data, $item['id']));
        }
        return $data;
    }

    public function filterDataByStatusTransaksi($type, $hasPenjemputan = false)
    {
        return $this->transaksiRepository->filterDataByStatusTransaksi($type, $hasPenjemputan);
    }

    public function doesntHavePenjemputan()
    {
        return $this->transaksiRepository->doesntHavePenjemputan();
    }
}

