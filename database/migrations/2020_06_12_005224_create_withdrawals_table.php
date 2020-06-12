<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('atasnama')->nullable();
            $table->string('rekening')->nullable();
            $table->string('bank')->nullable();
            $table->string('email')->nullable();
            $table->string('amount')->nullable();
            $table->string('notes')->nullable();
            $table->string('status')->nullable();
            $table->string('reference_no')->nullable();
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
        Schema::dropIfExists('withdrawals');
    }
}
