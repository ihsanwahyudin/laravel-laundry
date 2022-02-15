<?php

namespace App\Repositories\Eloquent;

use App\Models\DetailLogActivity;
use App\Models\ListTable;
use App\Models\LogActivity;
use App\Models\Transaksi;
use App\Repositories\Interfaces\Eloquent\LogActivityRepositoryInterface;
use Carbon\Carbon;

class LogActivityRepository implements LogActivityRepositoryInterface
{
    private $logActivity, $listTable, $detailLogActivity, $transaksi;

    public function __construct(LogActivity $logActivity, ListTable $listTable, DetailLogActivity $detailLogActivity, Transaksi $transaksi)
    {
        $this->logActivity = $logActivity;
        $this->listTable = $listTable;
        $this->detailLogActivity = $detailLogActivity;
        $this->transaksi = $transaksi;
    }

    public function create(array $payload)
    {
        return $this->logActivity->create($payload);
    }

    public function getMasterDataLogs()
    {
        return $this->logActivity->with(['referenceTable', 'user', 'detailLogActivity' => function($q) {
            $q->with('tableColumnList')->get();
        }])->latest()->get();
    }

    public function getTransaksiLogs()
    {
        return $this->transaksi->with('user')->latest()->get();
    }

    public function findTableByTableName($tableName)
    {
        return $this->listTable->with('columnList')->where('table_name', $tableName)->first();
    }

    public function createDetailLog(array $payload)
    {
        return $this->detailLogActivity->create($payload);
    }

    public function getDateLogs()
    {
        return $this->logActivity->selectRaw('SUBSTRING(created_at, 1, 10) AS date')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->orderBy('created_at', 'DESC')->groupBy('date')->get();
    }

    public function filterLogsMasterData(string $startDate, string $endDate)
    {
        return $this->logActivity->with(['referenceTable', 'user', 'detailLogActivity' => function($q) {
            $q->with('tableColumnList')->get();
        }])->whereBetween('created_at', [$startDate, $endDate])->latest()->get();
    }

    public function filterLogsTransaksi(string $startDate, string $endDate)
    {
        return $this->transaksi->with('user')->whereBetween('created_at', [$startDate, $endDate])->latest()->get();
    }
}
