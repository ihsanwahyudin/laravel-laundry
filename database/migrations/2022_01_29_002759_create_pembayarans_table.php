<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->double('biaya_tambahan');
            $table->double('diskon');
            $table->double('pajak');
            $table->double('total_pembayaran');
            $table->double('total_bayar');
            $table->timestamps();
            $table->foreign('transaksi_id')->references('id')->on('tb_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pembayaran');
    }
}
