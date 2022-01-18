<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_member', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tlp', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_member');
    }
}
