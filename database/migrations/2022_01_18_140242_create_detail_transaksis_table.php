<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('paket_id');
            $table->integer('qty');
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('transaksi_id')->references('id')->on('tb_transaksi');
            $table->foreign('paket_id')->references('id')->on('tb_paket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_transaksi');
    }
}
