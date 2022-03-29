<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    private $userRepository;
    private $logActivityService;

    public function __construct(UserRepositoryInterface $userRepository, LogActivityService $logActivityService)
    {
        $this->userRepository = $userRepository;
        $this->logActivityService = $logActivityService;
    }

    public function getAllData()
    {
        return $this->userRepository->allData();
    }

    public function storeData($payload)
    {
        try {
            DB::beginTransaction();
            $payload['password'] = Hash::make($payload['password']);
            $data = $this->userRepository->create($payload);
            Log::channel('activity')->info('Membuat data user baru', [
                'reference' => 'user',
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
            $data = $this->userRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                $changed['name'] = $data->name;
                Log::channel('activity')->info('Mengubah data user', [
                    'reference' => 'user',
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
            $data = $this->userRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data user', [
                'reference' => 'user',
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
