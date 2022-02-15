<?php

use App\Http\Controllers\LogActivityController;
use App\Models\ListTable;
use App\Models\TableColumnList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/migrate-table', function () {
    // $tables = DB::select('SHOW TABLES');
    // $tableList = [];
    // $exceptTable = ['migrations', 'password_resets', 'failed_jobs', 'personal_access_tokens', 'list_table', 'table_column_lists', 'tb_log_activity', 'tb_detail_log_activity'];
    // foreach($tables as $table)
    // {
    //     array_push($tableList, $table->Tables_in_db_laundry);
    // }
    // $tableList = array_values(array_diff($tableList, $exceptTable));
    // foreach($tableList as $table)
    // {
    //     $data = ListTable::create([
    //         'table_name' => $table
    //     ]);
    //     $columnList = DB::getSchemaBuilder()->getColumnListing($table);
    //     $exceptColumn = ['id', 'created_at', 'updated_at', 'deleted_at'];
    //     $columnList = array_values(array_diff($columnList, $exceptColumn));
    //     foreach($columnList as $column)
    //     {
    //         TableColumnList::create([
    //             'list_table_id' => $data['id'],
    //             'column_name' => $column
    //         ]);
    //     }
    // }
    return true;
});

Route::get('/migrate-column', function () {
    // return DB::getSchemaBuilder()->getColumnListing($table);
    // OR
    // return Schema::getColumnListing($table);
});

Route::get('/changed', function() {
    // $table = ListTable::findOrFail(1);
    // $table->update([
    //     'table_name' => 'hoho'
    // ]);

    // dd($table->getChanges());
    $table = ListTable::with('columnList')->where('table_name', 'tb_outlet')->first();
    // $table = ListTable::create([
    //     'table_name' => 'hoho'
    // ])->toArray();
    // $exceptColumn = ['id', 'created_at', 'updated_at', 'deleted_at'];
    // dd(array_diff(array_keys($table), $exceptColumn));
});

Route::get('/test', [LogActivityController::class, 'test']);
