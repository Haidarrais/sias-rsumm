<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDispositionToDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disposition', function (Blueprint $table) {
            $table->integer('is_disposition')->default(0);
            $table->integer('mail_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disposition', function (Blueprint $table) {
            $table->dropColumn('is_disposition');
            $table->dropColumn('mail_status')->default(0);
        });
    }
}
