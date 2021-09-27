<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('outbox');
        Schema::dropIfExists('inbox');
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('journal_id');
            $table->string('number');
            $table->string('sender');
            $table->string('regarding');
            $table->date('entry_date');
            $table->string('origin');
            $table->string('notes');
            $table->integer('type_id');
            $table->integer('mail_type');
            $table->boolean('status');
            $table->string('file');
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
        Schema::dropIfExists('mails');
    }
}
