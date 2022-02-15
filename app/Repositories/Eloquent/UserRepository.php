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
        return $this->user->with('outlet')->where('role', '!=', 'owner')->get();
    }

    public function create(array $payload)
    {
        return $this->user->create($payload);
    }

    public function updateDataById(array $payload, int $id)
    {
        $data = $this->user->findOrFail($id);
        $data->update($payload);
        return $data;
    }

    public function deleteDataById(int $id)
    {
        $data = $this->user->findOrFail($id);
        $data->delete();
        return $data;
    }
}
