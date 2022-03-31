<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsensiRequest;
use App\Services\AbsensiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbsensiController extends Controller
{
    private $absensiService;
    /**
     * Membuat property absensiService untuk mengakses service
     *
     */

    /**
     * Membuat Constructor untuk mengambil service
     *
     * @param AbsensiService $absensiService
     */
    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }
    /**
     * Fungsi Index digunakan untuk mengambil seluruh data absensi dari database
     *
     * @return JSON
     */
    public function index()
    {
        $data = $this->absensiService->getAllData();
        
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Fungsi Store untuk menyimpan data absensi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response $data JSON
     */
    public function store(AbsensiRequest $request)
    {
        $data = $this->absensiService->storeData($request->all());

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Fungsi update digunakan untuk mengubah data yang spesifik di dalam database berdasarkan ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JSON
     */
    public function update(AbsensiRequest $request, $id)
    {
        $data = $this->absensiService->updateDataById($request->all(), $id);

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
        $data = $this->absensiService->deleteDataById($id);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Fungsi updateStatus digunakan untuk mengubah status absensi di database berdasarkan ID
     *
     * @param  int  $id
     * @return JSON
     */
    public function updateStatus(Request $request, $id)
    {
        $data = $this->absensiService->updateDataById($request->all(), $id);

        return response()->json($data, Response::HTTP_OK);
    }
}
