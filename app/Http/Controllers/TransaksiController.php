<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Services\ExportService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    private $transaksiService;
    private $exportService;

    public function __construct(TransaksiService $transaksiService, ExportService $exportService)
    {
        $this->transaksiService = $transaksiService;
        $this->exportService = $exportService;
    }

    public function index()
    {
        $data = $this->transaksiService->getAllData();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getNonCashData()
    {
        $data = $this->transaksiService->getNonCashData();
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

    public function update(Request $request)
    {
        $validated = $request->validate([
            'transaksi.id' => ['required', 'exists:tb_transaksi,id'],
            'transaksi.status_pembayaran' => ['required', 'in:lunas,belum lunas'],
            'pembayaran.biaya_tambahan' => ['required', 'numeric'],
            'pembayaran.diskon' => ['required', 'numeric', 'max:100', 'min:0'],
            'pembayaran.pajak' => ['required', 'numeric', 'max:100', 'min:0'],
            'pembayaran.total_pembayaran' => ['required', 'numeric'],
            'pembayaran.total_bayar' => [$request['transaksi']['status_pembayaran'] === 'lunas' ? 'nullable' : 'required' , 'numeric'],
        ]);

        $data['transaksi'] = $this->transaksiService->updateTransaksi($request->all(), $request['transaksi']['id']);
        $data['pembayaran'] = $this->transaksiService->updatePembayaran($request['pembayaran'], $request['transaksi']['id']);
        return response()->json($data, Response::HTTP_OK);
    }

    public function updateStatusTransaksi(Request $request)
    {
        $validated = $request->validate([
            'transaksi.id' => ['required', 'exists:tb_transaksi,id'],
            'transaksi.status_transaksi' => ['required', 'in:baru,proses,selesai,diambil'],
        ]);
        $data['transaksi'] = $this->transaksiService->updateStatusTransaksi($validated);

        return response()->json($data, Response::HTTP_OK);
    }

    public function cetakFaktur($noInvoice)
    {
        return $this->exportService->cetakFaktur($noInvoice);
    }
}
