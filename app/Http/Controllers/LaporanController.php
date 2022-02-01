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

    public function getLaporanTransaksiPerOutlet()
    {
        $data = $this->laporanService->getLaporanTransaksiPerOutlet();
        return response()->json($data, Response::HTTP_OK);
    }
}
