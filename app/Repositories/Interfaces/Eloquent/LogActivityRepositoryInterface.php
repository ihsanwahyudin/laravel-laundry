<?php

namespace App\Repositories\Interfaces\Eloquent;

interface LogActivityRepositoryInterface
{
    public function create(array $payload);

    public function getAllLogs();

    public function findTableByTableName(string $tableName);

    public function createDetailLog(array $payload);

    public function getDateLogs();
}
