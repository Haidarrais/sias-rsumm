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
        if (Schema::hasColumns('disposition', ['surat_id'])) {
            Schema::dropColumns('disposition',['surat_id']);
            Schema::table('disposition', function (Blueprint $table) {
                $table->bigInteger('mail_id')->after('id');
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
        Schema::dropColumns('disposition',['mail_id']);
        Schema::table('disposition', function (Blueprint $table) {
            $table->integer('surat_id');
        });
    }
}
