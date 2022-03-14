<?php

namespace App\Repositories\Eloquent;

use App\Models\Member;
use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    private $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function allData()
    {
        return $this->member->withCount('transaksi')->orderBy('id', 'DESC')->get();
    }

    public function create(array $payload)
    {
        return $this->member->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        $data = $this->member->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id)
    {
        $data = $this->member->findOrFail($id);
        $data->delete();
        return $data;
    }
}
