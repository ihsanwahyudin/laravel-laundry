<?php

namespace App\Services;

use App\Repositories\Interfaces\Eloquent\LogActivityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LogActivityService
{
    private $logActivityRepository;

    public function __construct(LogActivityRepositoryInterface $logActivityRepository)
    {
        $this->logActivityRepository = $logActivityRepository;
    }

    public function createLog($tableName, $data, $action)
    {
        $table = $this->logActivityRepository->findTableByTableName($tableName);
        // 1 = CREATE , 2 = READ , 3 = UPDATE, 4 = DELETE, 5 = LOGIN
        $log = [
            'action' => $action,
            'reference_id' => $data['id'],
            'reference_table_id' => $table->id,
            'user_id' => Auth::user()->id
        ];

        $logActivity = $this->logActivityRepository->create($log);

        $exceptColumn = ['id', 'created_at', 'password', 'updated_at', 'deleted_at'];
        $allowedColumn = array_diff(array_keys($data), $exceptColumn);

        foreach($table->columnList as $item) {
            if(in_array($item->column_name, $allowedColumn)) {
                $detailLog = [
                    'log_activity_id' => $logActivity->id,
                    'table_column_lists_id' => $item->id,
                    'data' => $data[$item->column_name],
                ];
                $this->logActivityRepository->createDetailLog($detailLog);
            }
        }
    }

    public function createLogActivity($payload)
    {
        $this->logActivityRepository->create($payload);
    }

    public function getMasterDataLogs()
    {
        return $this->logActivityRepository->getMasterDataLogs();
    }

    public function findTableIdByTableName($tableName)
    {
        return $this->logActivityRepository->findTableByTableName($tableName);
    }

    public function getDateLogs()
    {
        return $this->logActivityRepository->getDateLogs();
    }

    public function getAllLogs()
    {
        $masterData = $this->logActivityRepository->getMasterDataLogs()->toArray();
        $transaksiData = $this->logActivityRepository->getTransaksiLogs()->toArray();

        $data = new Collection(array_merge($masterData, $transaksiData));
        $data = $data->sortByDesc('created_at')->groupBy(function($date) {
            return Carbon::parse($date['created_at'])->format('d-M-Y');
        });
        return $data;
    }

    public function filterLogs($payload)
    {
        $masterData = $this->logActivityRepository->filterLogsMasterData($payload['start_date'], $payload['end_date'])->toArray();
        $transaksiData = $this->logActivityRepository->filterLogsTransaksi($payload['start_date'], $payload['end_date'])->toArray();

        $data = new Collection(array_merge($masterData, $transaksiData));
        $data = $data->sortByDesc('created_at')->groupBy(function($date) {
            return Carbon::parse($date['created_at'])->format('d-M-Y');
        });
        return $data;
    }

    public function getLogsByUserId($userID)
    {
        $masterData = $this->logActivityRepository->getMasterDataLogsByUserID($userID)->toArray();
        $transaksiData = $this->logActivityRepository->getTransaksiLogsByUserID($userID)->toArray();

        $data = new Collection(array_merge($masterData, $transaksiData));
        $data = $data->sortByDesc('created_at')->groupBy(function($date) {
            return Carbon::parse($date['created_at'])->format('d-M-Y');
        });
        return $data;
    }
}
