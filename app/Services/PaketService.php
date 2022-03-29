<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\PaketRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::channel('activity')->info('Membuat data paket baru', [
                'reference' => 'paket',
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
            $data = $this->paketRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data paket', [
                    'reference' => 'paket',
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
            $data = $this->paketRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data paket', [
                'reference' => 'paket',
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
