<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_log_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_activity_id');
            $table->unsignedBigInteger('table_column_lists_id');
            $table->text('data');
            $table->timestamps();
            $table->foreign('log_activity_id')->references('id')->on('tb_log_activity');
            $table->foreign('table_column_lists_id')->references('id')->on('table_column_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_log_activity');
    }
}
