<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\PenjemputanRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::channel('activity')->info('Membuat data penjemputan baru', [
                'reference' => 'penjemputan',
                'status' => 'created',
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'data' => [...AllowedArrayLog::filter($data->toArray())]
            ]);
            DB::commit();
            return $data;
        } catch (QueryException $error) {
            DB::rollBack();
            return $error;
        }
    }

    public function updateDataById($payload, $id)
    {
        try {
            DB::beginTransaction();
            $data = $this->penjemputanRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data penjemputan', [
                    'reference' => 'penjemputan',
                    'status' => 'updated',
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'data' => [...AllowedArrayLog::filter($data->toArray())],
                    'changed_data' => [...AllowedArrayLog::filter($changed)]
                ]);
            }
            DB::commit();
            return $data;
        } catch (QueryException $error) {
            DB::rollBack();
            return $error;
        }
    }

    public function deleteDataById($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->penjemputanRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data penjemputan', [
                'reference' => 'penjemputan',
                'status' => 'deleted',
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'data' => [...AllowedArrayLog::filter($data->toArray())]
            ]);
            DB::commit();
            return $data;
        } catch (QueryException $error) {
            DB::rollBack();
            return $error;
        }
    }
}
