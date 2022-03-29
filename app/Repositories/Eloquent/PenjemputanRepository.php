<?php

namespace App\Repositories\Eloquent;

use App\Models\Penjemputan;
use App\Repositories\Interfaces\Eloquent\PenjemputanRepositoryInterface;

class PenjemputanRepository implements PenjemputanRepositoryInterface
{
    private $penjemputan;

    public function __construct(Penjemputan $penjemputan)
    {
        $this->penjemputan = $penjemputan;
    }

    public function allData() : object
    {
        return $this->penjemputan->with(['transaksi' => function($q) {
            $q->with(['member', 'user', 'detailTransaksi' => function($q) {
                $q->with('paket');
            }]);
        }])->get();
    }

    public function create(array $payload) : object
    {
        return $this->penjemputan->create($payload);
    }

    public function updateDataById(array $payload, int $id) : object
    {
        $data = $this->penjemputan->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id) : object
    {
        $data = $this->penjemputan->findOrFail($id);
        $data->delete();
        return $data;
    }
}
