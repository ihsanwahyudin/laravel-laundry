<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->string('kode_invoice', 100);
            $table->unsignedBigInteger('member_id');
            $table->date('tgl_bayar');
            $table->date('batas_waktu');
            $table->enum('metode_pembayaran', ['cash', 'dp', 'bayar nanti']);
            $table->enum('status_transaksi', ['baru', 'proses', 'selesai', 'diambil']);
            $table->enum('status_pembayaran', ['lunas', 'belum lunas']);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('outlet_id')->references('id')->on('tb_outlet');
            $table->foreign('member_id')->references('id')->on('tb_member');
            $table->foreign('user_id')->references('id')->on('tb_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksi');
    }
}
