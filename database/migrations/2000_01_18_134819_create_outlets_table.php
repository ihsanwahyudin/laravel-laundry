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

        // DB::unprepared('
        //     DROP TRIGGER IF EXISTS `on_insert_tb_outlet`;
        //     CREATE TRIGGER `on_insert_tb_outlet` AFTER INSERT ON `tb_outlet` FOR EACH ROW
        //     BEGIN
        //         INSERT INTO `tb_logging` (`action`, `created_at`) VALUES (`INSERT DATA tb_outlet`, CURRENT_TIMESTAMP);
        //     END;
        // ');

        // DB::unprepared('
        //     DROP TRIGGER IF EXISTS `on_update_tb_outlet`;
        //     CREATE TRIGGER `on_update_tb_outlet` AFTER UPDATE ON `tb_outlet` FOR EACH ROW
        //     BEGIN
        //         INSERT INTO `tb_logging` (`action`, `created_at`) VALUES (`UPDATE DATA tb_outlet`, CURRENT_TIMESTAMP);
        //     END;
        // ');

        // DB::unprepared('
        //     DROP TRIGGER IF EXISTS `on_delete_tb_outlet`;
        //     CREATE TRIGGER `on_delete_tb_outlet` BEFORE DELETE ON `tb_outlet` FOR EACH ROW
        //     BEGIN
        //         INSERT INTO `tb_logging` (`action`, `created_at`) VALUES (`DELETE DATA tb_outlet`, CURRENT_TIMESTAMP);
        //     END;
        // ');

        // DB::unprepared("
        //     DROP PROCEDURE IF EXISTS `insertOutlet`;
        //     CREATE PROCEDURE `insertOutlet` (
        //         IN p_nama VARCHAR(100),
        //         IN p_alamat TEXT,
        //         IN p_tlp VARCHAR(20)
        //     )
        //     BEGIN
        //         INSERT INTO `tb_outlet`(`nama`, `alamat`, `tlp`, `created_at`, `updated_at`)
        //         VALUES (p_nama, p_alamat, p_tlp, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
        //     END;
        // ");

        // DB::unprepared('
        //     DROP FUNCTION IF EXISTS `getDataOutlet`;
        //     CREATE FUNCTION `getDataOutlet`(pid INT)
        //     RETURNS VARCHAR(100)
        //     BEGIN
        //         DECLARE nama_outlet VARCHAR(20);

        //         SELECT nama INTO nama_outlet FROM tb_outlet WHERE id = pid;

        //         RETURN nama_outlet;
        //     END;
        // ');
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
