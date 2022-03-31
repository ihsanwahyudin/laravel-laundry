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

    /**
     * Query Untuk mengambil data terbaru dari database menggunakan Eloquent ORM
     * @return ?object
     */
    public function allData() : ?object
    {
        return $this->absensi->latest()->get();
    }

    /**
     * Query Untuk menyimpan data ke database menggunakan Eloquent ORM
     * @param array $payload
     * @return Object
     */
    public function create(array $payload) : object
    {
        return $this->absensi->create($payload);
    }

    /**
     * Query Untuk mengubah data di database menggunakan Eloquent ORM
     * @param array $payload, int $id
     * @return Object
     */
    public function updateDataById(array $payload, int $id) : object
    {
        $data = $this->absensi->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    /**
     * Query Untuk menghapus data di database menggunakan Eloquent ORM
     * @param int $id
     * @return Object
     */
    public function deleteDataById(int $id) : object
    {
        $data = $this->absensi->findOrFail($id);
        $data->delete();
        return $data;
    }
}
