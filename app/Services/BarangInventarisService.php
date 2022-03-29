<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\BarangInventarisRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();
            $data = $this->barangInventarisRepository->create($payload);
            Log::channel('activity')->info('Membuat data barang inventaris baru', [
                'reference' => 'barang inventaris',
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
            $data = $this->barangInventarisRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data barang inventaris', [
                    'reference' => 'barang inventaris',
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
            $data = $this->barangInventarisRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data barang inventaris', [
                'reference' => 'barang inventaris',
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
