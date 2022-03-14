<?php

namespace App\Repositories\Eloquent;

use App\Models\Paket;
use App\Repositories\Interfaces\Eloquent\PaketRepositoryInterface;

class PaketRepository implements PaketRepositoryInterface
{
    private $paket;

    public function __construct(Paket $paket)
    {
        $this->paket = $paket;
    }

    public function allData()
    {
        return $this->paket->with('outlet')->withCount('detailTransaksi')->orderBy('id', 'DESC')->get();
    }

    public function create(array $payload)
    {
        return $this->paket->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        $data = $this->paket->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id)
    {
        $data = $this->paket->findOrFail($id);
        $data->delete();
        return $data;
    }
}
