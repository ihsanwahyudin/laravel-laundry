<?php

namespace App\Http\Controllers;

use App\Logging\AllowedArrayLog;
use App\Logging\LogReader;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;


class TestController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public $example = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'jk' => 'L',
        ],
        [
            'id' => 2,
            'name' => 'Jane Doe',
            'jk' => 'P',
        ],
        [
            'id' => 3,
            'name' => 'Jane Doe',
            'jk' => 'P',
        ],
    ];

    public function test()
    {
        $users = User::all();
        $view = View::make('mail.index', compact('users'))->render();
        return response()->json([
            'html' => $view
        ]);
    }

    public function test2()
    {
        // $log = Log::channel('activity')->emergency('Database has been cracked !!!', [
        //     'user-id' => Auth::user()->id,
        // ]);
        // Log::channel('daily')->info('Test aja', ['user-id', Auth::user()->id]);

        // $storage = Storage::get('activity.log');

        // $json = json_decode($storage, true);
        // dd(123);
        // return view('test.test-1');

        // $array = [
        //     'id' => 1,
        //     'name' => 'test',
        //     'created_at' => null,
        //     'updated_at' => null
        // ];
        // $exceptColumn = ['id', 'created_at', 'password', 'updated_at', 'deleted_at'];
        $query = DB::select(Db::raw('CALL insertOutlet("test procedure", "test procedure", "0889999")'));

        dd($query);
        $data = User::all()->first()->toArray();
        $filtered = AllowedArrayLog::filter($data, 'me');
        dd($filtered);

        // $log = LogReader::getLogs();
        $data = LogReader::getLogs();
        // dd($data);
        $data['data'] = (new Collection($data['data']))->whereBetween('date', ['2022-03-22', '2022-03-22'])->toArray();
        dd($data);
        return $data;
    }

    public function getDataKaryawan()
    {
        $data = $this->userService->getAllData();

        return response()->json($data, Response::HTTP_OK);
    }
}
