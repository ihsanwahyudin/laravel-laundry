<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\PenjemputanRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PenjemputanService
{

    private $penjemputanRepository;
    private $logActivityService;

    public function __construct(PenjemputanRepositoryInterface $penjemputanRepository, LogActivityService $logActivityService)
    {
        $this->penjemputanRepository = $penjemputanRepository;
        $this->logActivityService = $logActivityService;
    }

    public function getAllData()
    {
        return $this->penjemputanRepository->allData();
    }

    public function storeData($payload)
    {
        try {
            DB::beginTransaction();
            $data = $this->penjemputanRepository->create($payload);
            $this->logActivityService->createLog('tb_penjemputan', $data->toArray(), 1);
            DB::commit();
            return $data;
        } catch (QueryException $error) {
            DB::rollBack();
            return $error;
        }
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->penjemputanRepository->updateDataById($payload, $id);
        $changed = $data->getChanges();
        if(count($changed) > 0) {
            $changed['id'] = $data->id;
            $this->logActivityService->createLog('tb_penjemputan', $changed, 3);
        }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->penjemputanRepository->deleteDataById($id);
        $this->logActivityService->createLog('tb_penjemputan', ['id' => $data->id, 'petugas_penjemput' => $data->petugas_penjemput], 4);
        return $data;
    }
}
