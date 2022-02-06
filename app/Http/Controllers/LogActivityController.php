<?php

namespace App\Http\Controllers;

use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivityController extends Controller
{
    private $logActivityService;

    public function __construct(LogActivityService $logActivityService)
    {
        $this->logActivityService = $logActivityService;
    }

    public function getAllActivities()
    {
        $data['logs'] = $this->logActivityService->getAllLogs();
        $data['date'] = $this->logActivityService->getDateLogs();
        return response()->json($data, Response::HTTP_OK);
    }
}
