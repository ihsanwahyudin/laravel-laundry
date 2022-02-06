<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;

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
        $data = $this->memberRepository->create($payload);
        $this->logActivityService->createLog('tb_member', $data->toArray(), 1);
        return $data;
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->memberRepository->updateDataById($payload, $id);
        $changed = $data->getChanges();
        if(count($changed) > 0) {
            $changed['id'] = $data->id;
            $this->logActivityService->createLog('tb_member', $changed, 3);
        }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->memberRepository->deleteDataById($id);
        $this->logActivityService->createLog('tb_outlet', ['id' => $data->id, 'nama' => $data->nama], 4);
        return $data;
    }
}
