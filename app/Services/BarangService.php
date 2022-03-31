<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\BarangRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangService
{
    /**
     * Membuat property barangRepository untuk mengakses repository
     */
    private $barangRepository;

    /**
     * Membuat constructor untuk mengambil repository
     * @param BarangRepositoryInterface $barangRepository
     */
    public function __construct(BarangRepositoryInterface $barangRepository)
    {
        $this->barangRepository = $barangRepository;
    }

    /**
     * Membuat method untuk mengambil semua data
     * @return Object | null
     */
    public function getAllData()
    {
        return $this->barangRepository->allData();
    }


    /**
     * Membuat method untuk menyimpan data sekaligus track log aktivitas
     * @param Array $payload
     * @return Object
     */
    public function storeData($payload)
    {
        try {
            DB::beginTransaction();
            $data = $this->barangRepository->create($payload);
            Log::channel('activity')->info('Membuat data barang baru', [
                'reference' => 'barang',
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

    /**
     * Membuat method untuk mengubah data sekaligus track log aktivitas
     * @param Array $payload, Int $id
     * @return Object
     */
    public function updateDataById($payload, $id)
    {
        try {
            DB::beginTransaction();
            $data = $this->barangRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data barang', [
                    'reference' => 'barang',
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

    /**
     * Membuat method untuk menghapus data sekaligus track log aktivitas
     * @param Int $id
     * @return Object
     */
    public function deleteDataById($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->barangRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data barang', [
                'reference' => 'barang',
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
