<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_payment', function (Blueprint $table) {
            $table->id();
            $table->string('client_key_sandbox')->nullable();
            $table->string('server_key_sandbox')->nullable();
            $table->string('client_key_production')->nullable();
            $table->string('server_key_production')->nullable();
            $table->string('environment')->nullable();
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
        Schema::dropIfExists('pengaturan_payment');
    }
}
