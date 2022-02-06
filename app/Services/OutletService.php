<?php

namespace App\Services;

use App\Models\ListTable;
use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OutletService
{
    private $outletRepository;
    private $logActivityService;

    public function __construct(OutletRepositoryInterface $outletRepository, LogActivityService $logActivityService)
    {
        $this->outletRepository = $outletRepository;
        $this->logActivityService = $logActivityService;
    }

    public function getAllData()
    {
        return $this->outletRepository->allData();
    }

    public function storeData($payload)
    {
        $data = $this->outletRepository->create($payload);
        $this->logActivityService->createLog('tb_outlet', $data->toArray(), 1);
        return $data;
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->outletRepository->updateDataById($payload, $id);
        $changed = $data->getChanges();
        if(count($changed) > 0) {
            $changed['id'] = $data->id;
            $this->logActivityService->createLog('tb_outlet', $changed, 3);
        }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->outletRepository->deleteDataById($id);
        $this->logActivityService->createLog('tb_outlet', ['id' => $data->id, 'nama' => $data->nama], 4);
        return $data;
    }
}
