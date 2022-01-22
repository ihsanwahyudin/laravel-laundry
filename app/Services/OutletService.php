<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;

class OutletService
{
    private $outletRepository;

    public function __construct(OutletRepositoryInterface $outletRepository)
    {
        $this->outletRepository = $outletRepository;
    }

    public function getAllData()
    {
        return $this->outletRepository->allData();
    }

    public function storeData($payload)
    {
        return $this->outletRepository->create($payload);
    }

    public function updateDataById($payload, $id)
    {
        return $this->outletRepository->updateDataById($payload, $id);
    }

    public function deleteDataById($id)
    {
        return $this->outletRepository->deleteDataById($id);
    }
}
