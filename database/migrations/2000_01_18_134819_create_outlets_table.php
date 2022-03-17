<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOutletsTable extends Migration
{
    /**r
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_outlet', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('tlp', 20);
            $table->timestamps();
        });

        DB::unprepared('
            DROP PROCEDURE IF EXISTS `insertOutlet`;
            CREATE PROCEDURE `insertOutlet` (
                IN nama VARCHAR(100),
                IN alamat TEXT,
                IN tlp VARCHAR(20)
            )
            BEGIN
                INSERT INTO tb_outlet (nama, alamat, tlp)
                VALUES (nama, alamat, tlp);
            END;
        ');

        DB::unprepared('
            DROP FUNCTION IF EXISTS `getDataOutlet`;
            CREATE FUNCTION `getDataOutlet`(pid INT)
            RETURNS VARCHAR(100)
            BEGIN
                DECLARE nama_outlet VARCHAR(20);

                SELECT nama INTO nama_outlet FROM tb_outlet WHERE id = pid;

                RETURN nama_outlet;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_outlet');
    }
}
