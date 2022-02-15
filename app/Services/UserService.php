<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
        $payload['password'] = Hash::make($payload['password']);
        $data = $this->userRepository->create($payload);
        $this->logActivityService->createLog('tb_user', $data->toArray(), 1);
        return $data;
    }

    public function updateDataById($payload, $id)
    {
        $data = $this->userRepository->updateDataById($payload, $id);
        $changed = $data->getChanges();
        if(count($changed) > 0) {
            $changed['id'] = $data->id;
            $changed['name'] = $data->name;
            $this->logActivityService->createLog('tb_user', $changed, 3);
        }
        return $data;
    }

    public function deleteDataById($id)
    {
        $data = $this->userRepository->deleteDataById($id);
        $this->logActivityService->createLog('tb_user', ['id' => $data->id, 'email' => $data->email], 4);
        return $data;
    }
}
