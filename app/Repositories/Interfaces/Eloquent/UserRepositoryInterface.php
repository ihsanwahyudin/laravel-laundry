<?php

namespace App\Repositories\Interfaces\Eloquent;

interface UserRepositoryInterface
{
    public function allData();

    public function create(array $payload);

    public function updateDataById(array $payload, int $id);

    public function deleteDataById(int $id);
}
