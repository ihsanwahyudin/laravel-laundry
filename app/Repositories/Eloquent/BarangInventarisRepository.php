<?php

namespace App\Repositories\Eloquent;

use App\Models\BarangInventaris;
use App\Repositories\Interfaces\Eloquent\BarangInventarisRepositoryInterface;

class BarangInventarisRepository implements BarangInventarisRepositoryInterface
{
    private $barangInventaris;

    public function __construct(BarangInventaris $barangInventaris)
    {
        $this->barangInventaris = $barangInventaris;
    }

    public function allData()
    {
        return $this->barangInventaris->orderBy('id', 'DESC')->get();
    }

    public function create(array $payload)
    {
        return $this->barangInventaris->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        $data = $this->barangInventaris->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id)
    {
        $data = $this->barangInventaris->findOrFail($id);
        $data->delete();
        return $data;
    }
}
