<?php

namespace App\Repositories\Eloquent;

use App\Models\Outlet;
use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;

class OutletRepository implements OutletRepositoryInterface
{
    private $outlet;

    public function __construct(Outlet $outlet)
    {
        $this->outlet = $outlet;
    }

    public function allData()
    {
        return $this->outlet->withCount('paket')->get();
    }

    public function create(array $payload)
    {
        return $this->outlet->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        $data = $this->outlet->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id)
    {
        $data = $this->outlet->findOrFail($id);
        $data->delete();
        return $data;
    }
}
