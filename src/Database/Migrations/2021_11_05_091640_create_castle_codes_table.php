<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastleCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Backup Codes table
        Schema::create('castle_codes', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->mediumText('secret')->nullable();
            $table->longText('codes')->nullable();
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
        Schema::dropIfExists('castle_codes');
    }
}
