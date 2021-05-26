<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran');
            $table->unsignedBigInteger('siswa_id');
            $table->string('metode_pembayaran');
            $table->integer('total');
            $table->string('status');
            $table->json('pembayaran_detail')->nullable();
            $table->string('token')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
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
        Schema::dropIfExists('transaksi_pembayaran');
    }
}
