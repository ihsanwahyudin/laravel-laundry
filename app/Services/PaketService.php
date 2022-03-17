<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\PaketRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PaketService
{
    private $paketRepository;
    private $logActivityService;

    public function __construct(PaketRepositoryInterface $paketRepository, LogActivityService $logActivityService)
    {
        $this->paketRepository = $paketRepository;
        $this->logActivityService = $logActivityService;
    }

    public function getAllData()
    {
        return $this->paketRepository->allData();
    }

    public function storeData($payload)
    {
        try {
            DB::beginTransaction();
            $data = $this->paketRepository->create($payload);
            $this->logActivityService->createLog('tb_paket', $data->toArray(), 1);
            DB::commit();
            return $data;
        } catch (QueryException $errors) {
            DB::rollBack();
            return $errors;
        }
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->paketRepository->updateDataById($payload, $id);
        $changed = $data->getChanges();
        if(count($changed) > 0) {
            $changed['id'] = $data->id;
            $this->logActivityService->createLog('tb_paket', $changed, 3);
        }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->paketRepository->deleteDataById($id);
        $this->logActivityService->createLog('tb_paket', ['id' => $data->id, 'nama_paket' => $data->nama_paket], 4);
        return $data;
    }
}
