<?php

namespace App\Repositories\Interfaces\Eloquent;

interface TransaksiRepositoryInterface
{
    public function getAllTransactionData();

    public function createTransaksi(array $payload);

    public function getLatestTransaksiData();

    public function createPembayaran(array $payload);

    public function createDetailTransaksi(array $payload);
}