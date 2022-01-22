<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;

class MemberService
{
    private $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllData()
    {
        return $this->memberRepository->allData();
    }

    public function storeData($payload)
    {
        return $this->memberRepository->create($payload);
    }

    public function updateDataById($payload, $id)
    {
        return $this->memberRepository->updateDataById($payload, $id);
    }

    public function deleteDataById($id)
    {
        return $this->memberRepository->deleteDataById($id);
    }
}
