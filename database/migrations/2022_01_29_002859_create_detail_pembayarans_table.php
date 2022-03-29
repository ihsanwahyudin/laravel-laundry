<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembayaran_id');
            $table->double('total_bayar');
            $table->timestamps();
            $table->foreign('pembayaran_id')->references('id')->on('tb_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_pembayaran');
    }
}
