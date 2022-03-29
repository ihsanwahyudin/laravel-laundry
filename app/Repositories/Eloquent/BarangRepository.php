<?php

namespace App\Repositories\Eloquent;

use App\Models\Barang;
use App\Repositories\Interfaces\Eloquent\BarangRepositoryInterface;

class BarangRepository implements BarangRepositoryInterface
{
    private $barang;

    public function __construct(Barang $barang)
    {
        $this->barang = $barang;
    }

    public function allData() : ?object
    {
        return $this->barang->get();
    }

    public function create(array $payload) : object
    {
        return $this->barang->create($payload);
    }

    public function updateDataById(array $payload, int $id) : object
    {
        $data = $this->barang->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id) : object
    {
        $data = $this->barang->findOrFail($id);
        $data->delete();
        return $data;
    }
}
