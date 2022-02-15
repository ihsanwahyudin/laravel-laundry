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
        $data = $this->logActivityService->getAllLogs();
        return response()->json($data, Response::HTTP_OK);
    }

    public function filterActivities(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = $this->logActivityService->filterLogs($validated);
        return response()->json($data, Response::HTTP_OK);
    }

    public function test()
    {
        return $this->logActivityService->getAllLogs();
    }
}
