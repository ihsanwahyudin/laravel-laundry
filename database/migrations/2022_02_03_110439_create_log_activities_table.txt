<?php

use App\Models\ListTable;
use App\Models\TableColumnList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_log_activity', function (Blueprint $table) {
            $table->id();
            $table->enum('action', [1, 2, 3, 4, 5]); // 1 = CREATE , 2 = READ , 3 = UPDATE, 4 = DELETE, 5 = LOGIN
            $table->unsignedBigInteger('reference_id');
            $table->unsignedBigInteger('reference_table_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('reference_table_id')->references('id')->on('list_table');
            $table->foreign('user_id')->references('id')->on('tb_user');
        });

        $tables = DB::select('SHOW TABLES');
        $tableList = [];
        $exceptTable = ['migrations', 'password_resets', 'failed_jobs', 'personal_access_tokens', 'list_table', 'table_column_lists', 'tb_log_activity', 'tb_detail_log_activity'];
        foreach($tables as $table)
        {
            array_push($tableList, $table->Tables_in_db_laundry);
        }
        $tableList = array_values(array_diff($tableList, $exceptTable));
        foreach($tableList as $table)
        {
            $data = ListTable::create([
                'table_name' => $table
            ]);
            $columnList = DB::getSchemaBuilder()->getColumnListing($table);
            $exceptColumn = ['id', 'created_at', 'updated_at', 'deleted_at'];
            $columnList = array_values(array_diff($columnList, $exceptColumn));
            foreach($columnList as $column)
            {
                TableColumnList::create([
                    'list_table_id' => $data['id'],
                    'column_name' => $column
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_log_activity');
    }
}
