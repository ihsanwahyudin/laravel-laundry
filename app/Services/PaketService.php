<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\PaketRepositoryInterface;

class PaketService
{
    private $paketRepository;

    public function __construct(PaketRepositoryInterface $paketRepository)
    {
        $this->paketRepository = $paketRepository;
    }

    public function getAllData()
    {
        return $this->paketRepository->allData();
    }

    public function storeData($payload)
    {
        return $this->paketRepository->create($payload);
    }

    public function updateDataById($payload, $id)
    {
        return $this->paketRepository->updateDataById($payload, $id);
    }

    public function deleteDataById($id)
    {
        return $this->paketRepository->deleteDataById($id);
    }
}
