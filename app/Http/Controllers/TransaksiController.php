<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    private $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    public function index()
    {
        $data = $this->transaksiService->getAllData();

        // return response()->json($data, Response::HTTP_OK);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(TransaksiRequest $request)
    {

        $data['transaksi'] = $this->transaksiService->storeTransaksi($request->transaksi);
        $data['pembayaran'] = $this->transaksiService->storePembayaran($request->transaksi, $data['transaksi']['id']);
        $data['detailTransaksi'] = $this->transaksiService->storeDetailTransaksi($request->detailTransaksi, $data['transaksi']['id']);

        return response()->json($data, Response::HTTP_OK);
    }
}
