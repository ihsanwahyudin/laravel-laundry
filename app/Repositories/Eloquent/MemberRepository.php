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
        return $this->member->all();
    }

    public function create(array $payload)
    {
        return $this->member->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        return $this->member->findOrFail($id)->update($payload);
    }

    public function deleteDataById(int $id)
    {
        return $this->member->findOrFail($id)->delete();
    }
}
