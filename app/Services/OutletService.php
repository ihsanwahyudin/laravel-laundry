<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Models\ListTable;
use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();
            $data = $this->outletRepository->create($payload);
            Log::channel('activity')->info('Membuat data outlet baru', [
                'reference' => 'outlet',
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
            $data = $this->outletRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data outlet', [
                    'reference' => 'outlet',
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
            $data = $this->outletRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data outlet', [
                'reference' => 'outlet',
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
