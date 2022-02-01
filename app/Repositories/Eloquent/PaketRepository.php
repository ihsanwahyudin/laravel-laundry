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
        return $this->paket->with('outlet')->get();
    }

    public function create(array $payload)
    {
        return $this->paket->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        return $this->paket->findOrFail($id)->update($payload);
    }

    public function deleteDataById(int $id)
    {
        return $this->paket->findOrFail($id)->delete();
    }
}
