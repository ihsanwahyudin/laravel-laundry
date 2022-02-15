<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LaporanController extends Controller
{
    private $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function getLaporanTransaksi()
    {
        $data = $this->laporanService->getLaporanTransaksi();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getLaporanTransaksiBetweenDate($startDate, $endDate)
    {
        $data = $this->laporanService->getLaporanTransaksiBetweenDate($startDate, $endDate);
        return response()->json($data, Response::HTTP_OK);
    }

    public function getLaporanTransaksiPerOutlet()
    {
        $data = $this->laporanService->getLaporanTransaksiPerOutlet();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getIncomeCurrentMonth()
    {
        $data = $this->laporanService->getIncomeCurrentMonth();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getTransactionAmount()
    {
        $data = $this->laporanService->getTransactionAmount();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getNumberOfMember()
    {
        $data = $this->laporanService->getNumberOfMember();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getRecentlyTransaction()
    {
        $data = $this->laporanService->getRecentlyTransaction();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getIncomePerDayCurrentMonth()
    {
        $data = $this->laporanService->getIncomePerDayCurrentMonth();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getRecentlyActivity()
    {
        $data = $this->laporanService->getRecentlyActivity();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getLatestTransaction($limit)
    {
        $data = $this->laporanService->getLatestTransaction($limit);
        return response()->json($data, Response::HTTP_OK);
    }

    public function getAmountOfTransactionPerStatusTransaction()
    {
        $data = $this->laporanService->getAmountOfTransactionPerStatusTransaction();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getAmountOfTransactionPerDayPerStatusTransaction()
    {
        $data = $this->laporanService->getAmountOfTransactionPerDayPerStatusTransaction();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getNumberOfMemberPerGender()
    {
        $data = $this->laporanService->getNumberOfMemberPerGender();
        return response()->json($data, Response::HTTP_OK);
    }
}
