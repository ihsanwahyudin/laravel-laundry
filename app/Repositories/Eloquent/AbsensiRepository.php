<?php

namespace App\Repositories\Eloquent;

use App\Models\Absensi;
use App\Repositories\Interfaces\Eloquent\AbsensiRepositoryInterface;

class AbsensiRepository implements AbsensiRepositoryInterface
{
    private $absensi;

    public function __construct(Absensi $absensi)
    {
        $this->absensi = $absensi;
    }

    public function allData() : ?object
    {
        return $this->absensi->latest()->get();
    }

    public function create(array $payload) : object
    {
        return $this->absensi->create($payload);
    }

    public function updateDataById(array $payload, int $id) : object
    {
        $data = $this->absensi->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id) : object
    {
        $data = $this->absensi->findOrFail($id);
        $data->delete();
        return $data;
    }
}
