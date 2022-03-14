<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\BarangInventarisRepositoryInterface;

class BarangInventarisService
{
    private $barangInventarisRepository;

    public function __construct(BarangInventarisRepositoryInterface $barangInventarisRepository)
    {
        $this->barangInventarisRepository = $barangInventarisRepository;
    }

    public function getAllData()
    {
        return $this->barangInventarisRepository->allData();
    }

    public function storeData($payload)
    {
        $data = $this->barangInventarisRepository->create($payload);
        // $this->logActivityService->createLog('tb_outlet', $data->toArray(), 1);
        return $data;
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->barangInventarisRepository->updateDataById($payload, $id);
        // $changed = $data->getChanges();
        // if(count($changed) > 0) {
        //     $changed['id'] = $data->id;
        //     $this->logActivityService->createLog('tb_outlet', $changed, 3);
        // }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->barangInventarisRepository->deleteDataById($id);
        // $this->logActivityService->createLog('tb_outlet', ['id' => $data->id, 'nama' => $data->nama], 4);
        return $data;
    }
}
