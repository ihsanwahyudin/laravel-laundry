<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletRequest;
use App\Services\OutletService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class OutletController extends Controller
{
    private $outletService;

    public function __construct(OutletService $outletService)
    {
        $this->outletService = $outletService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outlet = $this->outletService->getAllData();
        return DataTables::of($outlet)
            ->addIndexColumn()
            // ->addColumn('action', function ($outlet) {
            //     $buttons = '<div class="d-flex justify-content-center gap-2">';
            //     $buttons .=
            //         '<button class="d-flex align-items-center btn btn-outline-success rounded-pill fs-6 p-2 update-btn" data-id="'.$outlet->id.'" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-pencil-square"></i></button>';
            //     $buttons .=
            //         '<button class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-id="'.$outlet->id.'"><i class="bi bi-trash"></i></button>';
            //     $buttons .= '</div>';

            //     return $buttons;
            // })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->outletService->getAllData();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutletRequest $request)
    {
        $data = $this->outletService->storeData($request->all());

        return response()->json($data, Response::HTTP_OK);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OutletRequest $request, $id)
    {
        $data = $this->outletService->updateDataById($request->all(), $id);

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
        $data = $this->outletService->deleteDataById($id);

        return response()->json($data, Response::HTTP_OK);
    }
}
