<?php

namespace App\Services;

use App\Logging\AllowedArrayLog;
use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberService
{
    private $memberRepository;
    private $logActivityService;

    public function __construct(MemberRepositoryInterface $memberRepository, LogActivityService $logActivityService)
    {
        $this->memberRepository = $memberRepository;
        $this->logActivityService = $logActivityService;
    }

    public function getAllData()
    {
        return $this->memberRepository->allData();
    }

    public function storeData($payload)
    {
        try {
            DB::beginTransaction();
            $data = $this->memberRepository->create($payload);
            Log::channel('activity')->info('Membuat data member baru', [
                'reference' => 'member',
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
            $data = $this->memberRepository->updateDataById($payload, $id);
            $changed = $data->getChanges();
            if(count($changed) > 0) {
                $changed['id'] = $data->id;
                Log::channel('activity')->info('Mengubah data member', [
                    'reference' => 'member',
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
            $data = $this->memberRepository->deleteDataById($id);
            Log::channel('activity')->info('Menghapus data member', [
                'reference' => 'member',
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
