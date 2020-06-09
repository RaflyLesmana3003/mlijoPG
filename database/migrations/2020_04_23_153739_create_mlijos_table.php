<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlijosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlijos', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('bank')->nullable();
            $table->string('atasnama')->nullable();
            $table->string('rekening')->nullable();
            $table->string('saldo')->nullable();
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
        Schema::dropIfExists('mlijos');
    }
}
