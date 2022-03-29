<?php
namespace App\Logging;

class LogReader
{
    private static function getLogFileDates()
    {
        $dates = [];
        $files = glob(storage_path('logs/*/*/activity-*.log'));
        $files = array_reverse($files);
        foreach ($files as $path) {
            $fileName = basename($path);
            preg_match('/(?<=activity-)(.*)(?=.log)/', $fileName, $dtMatch);
            $date = $dtMatch[0];
            array_push($dates, $date);
        }

        return $dates;
    }

    private static function findLogs(array $config = [])
    {

        $availableDates = Self::getLogFileDates();

        if (count($availableDates) == 0) {
            return[
                'success' => false,
                'message' => 'No log available'
            ];
        }

        $configDate = isset($config['date']) ? $config['date'] : $availableDates[0];

        if (!in_array($configDate, $availableDates)) {
            return [
                'success' => false,
                'message' => 'No log file found with selected date ' . $configDate
            ];
        }

        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):\s(?<message>.*)\|\s(?<context>.*)/m";

        $data = [];
        foreach($availableDates as $date) {
            $fileName = 'activity-' . $date . '.log';
            $content = file_get_contents(storage_path('logs/'.date('Y/m/', strtotime($date)). $fileName));
            preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

            $logs = [];
            if(isset($config['user_id'])) {
                foreach ($matches as $match) {
                    $context = (array)json_decode($match['context']);
                    if($config['user_id'] == $context['user_id']) {
                        $logs[] = [
                            'timestamp' => $match['date'],
                            'env' => $match['env'],
                            'type' => $match['type'],
                            'message' => $match['message'],
                            'context' => $context
                        ];
                    } else {
                        continue;
                    }
                }
            } else {
                foreach ($matches as $match) {
                    $logs[] = [
                        'timestamp' => $match['date'],
                        'env' => $match['env'],
                        'type' => $match['type'],
                        'message' => $match['message'],
                        'context' => (array)json_decode($match['context'])
                    ];
                }
            }
            $logs = array_reverse($logs);

            preg_match('/(?<=activity-)(.*)(?=.log)/', $fileName, $dtMatch);
            $date = $dtMatch[0];

            if(count($logs) > 0) {
                $data[] = [
                    'date' => $date,
                    'filename' => $fileName,
                    'logs' => $logs
                ];
            }
        }

        return[
            'success' => true,
            'available_log_dates' => $availableDates,
            'data' => $data
        ];
    }

    public static function getLogs(array $config = [])
    {
        return Self::findLogs($config);
    }
}

