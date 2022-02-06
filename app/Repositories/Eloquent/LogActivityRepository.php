<?php

namespace App\Repositories\Eloquent;

use App\Models\DetailLogActivity;
use App\Models\ListTable;
use App\Models\LogActivity;
use App\Repositories\Interfaces\Eloquent\LogActivityRepositoryInterface;
use Carbon\Carbon;

class LogActivityRepository implements LogActivityRepositoryInterface
{
    private $logActivity;
    private $listTable;
    private $detailLogActivity;

    public function __construct(LogActivity $logActivity, ListTable $listTable, DetailLogActivity $detailLogActivity)
    {
        $this->logActivity = $logActivity;
        $this->listTable = $listTable;
        $this->detailLogActivity = $detailLogActivity;
    }

    public function create(array $payload)
    {
        return $this->logActivity->create($payload);
    }

    public function getAllLogs()
    {
        return $this->logActivity->with(['referenceTable', 'user', 'detailLogActivity' => function($q) {
            $q->with('tableColumnList')->get();
        }])->orderBy('created_at', 'DESC')->get();
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
}
