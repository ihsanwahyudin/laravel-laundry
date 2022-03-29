<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Services\BarangService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BarangController extends Controller
{
    private $barangService;
    /**
     * Membuat property barangService untuk mengakses service
     *
     * @param BarangService $barangService
     */

    /**
     * Membuat Constructor untuk mengambil service
     *
     * @param BarangService $barangService
     */
    public function __construct(BarangService $barangService)
    {
        $this->barangService = $barangService;
    }
    /**
     * Fungsi Index digunakan untuk mengambil seluruh data barang dari database
     *
     * @return JSON
     */
    public function index()
    {
        $data = $this->barangService->getAllData();

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Fungsi Store untuk menyimpan data barang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response $data JSON
     */
    public function store(BarangRequest $request)
    {
        $data = $this->barangService->storeData($request->all());

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Fungsi update digunakan untuk mengubah data yang spesifik di dalam database berdasarkan ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JSON
     */
    public function update(BarangRequest $request, $id)
    {
        $data = $this->barangService->updateDataById($request->all(), $id);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Fungsi destroy digunakan untuk menghapus data di database berdasarkan ID
     *
     * @param  int  $id
     * @return JSON
     */
    public function destroy($id)
    {
        $data = $this->barangService->deleteDataById($id);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Fungsi updateStatus digunakan untuk mengubah status barang di database berdasarkan ID
     *
     * @param  int  $id
     * @return JSON
     */
    public function updateStatus(Request $request, $id)
    {
        $data = $this->barangService->updateDataById($request->all(), $id);

        return response()->json($data, Response::HTTP_OK);
    }
}
