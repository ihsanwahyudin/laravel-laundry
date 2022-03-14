<?php

namespace App\Repositories\Interfaces\Eloquent;

interface LogActivityRepositoryInterface
{
    public function create(array $payload);

    public function getMasterDataLogs();

    public function getTransaksiLogs();

    public function findTableByTableName(string $tableName);

    public function createDetailLog(array $payload);

    public function getDateLogs();

    public function filterLogsMasterData(string $startDate, string $endDate);

    public function filterLogsTransaksi(string $startDate, string $endDate);

    public function getMasterDataLogsByUserID(int $id);

    public function getTransaksiLogsByUserID(int $id);
}
