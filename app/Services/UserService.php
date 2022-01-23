<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllData()
    {
        return $this->userRepository->allData();
    }

    public function storeData($payload)
    {
        $payload['password'] = Hash::make($payload['password']);
        return $this->userRepository->create($payload);
    }

    public function updateDataById($payload, $id)
    {
        return $this->userRepository->updateDataById($payload, $id);
    }

    public function deleteDataById($id)
    {
        return $this->userRepository->deleteDataById($id);
    }
}
