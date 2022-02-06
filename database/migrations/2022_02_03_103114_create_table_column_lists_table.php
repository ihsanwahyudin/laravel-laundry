<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableColumnListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_column_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_table_id');
            $table->string('column_name', 255);
            $table->timestamps();
            $table->foreign('list_table_id')->references('id')->on('list_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_column_lists');
    }
}
