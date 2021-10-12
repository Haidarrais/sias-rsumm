<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnTujuanToDivisionIdAtDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('disposition', ['tujuan','surat_id'])) {
            Schema::dropColumns('disposition',[ 'tujuan', 'surat_id']);
            Schema::table('disposition', function (Blueprint $table) {
                $table->bigInteger('mail_id')->after('id');
                $table->bigInteger('division_id')->after('mail_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('disposition', ['tujuan', 'surat_id'])) {
            Schema::dropColumns('disposition',[ 'tujuan', 'surat_id']);
    }}
}
