<?php

namespace App\Repositories\Interfaces\Eloquent;

interface AbsensiRepositoryInterface
{
    public function allData() : object|null;

    public function create(array $payload) : object;

    public function updateDataById(array $payload, int $id) : object;

    public function deleteDataById(int $id) : object;
}
