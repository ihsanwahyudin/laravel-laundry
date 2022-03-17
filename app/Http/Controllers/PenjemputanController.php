<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjemputanRequest;
use App\Services\PenjemputanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PenjemputanController extends Controller
{
    private $penjemputanService;

    public function __construct(PenjemputanService $penjemputanService)
    {
        $this->penjemputanService = $penjemputanService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->penjemputanService->getAllData();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenjemputanRequest $request)
    {
        $data = $this->penjemputanService->storeData($request->all());

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $this->penjemputanService->updateDataById($request->all(), $id);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PenjemputanRequest $request, $id)
    {
        $data = $this->penjemputanService->updateDataById($request->all(), $id);

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->penjemputanService->deleteDataById($id);

        return response()->json($data, Response::HTTP_OK);
    }
}
