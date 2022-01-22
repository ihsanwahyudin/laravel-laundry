<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\Eloquent\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function allData()
    {
        return $this->user->with('outlet')->get();
    }

    public function create(array $payload)
    {
        return $this->user->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        return $this->user->findOrFail($id)->update($payload);
    }

    public function deleteDataById(int $id)
    {
        return $this->user->findOrFail($id)->delete();
    }
}
