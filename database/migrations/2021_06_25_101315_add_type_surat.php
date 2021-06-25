<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbox', function (Blueprint $table) {
            $table->integer('type_id')
                    ->after('inbox_origin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('inbox', function (Blueprint $table) {
            $table->integer('type_id')
                    ->after('inbox_origin');
        });
    }
}
