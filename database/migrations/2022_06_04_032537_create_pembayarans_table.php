<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id');
            $table->foreignId('user_id');
            $table->string('slug')->unique();
            $table->string('no_transfer');
            $table->string('durasi_sewa');
            $table->integer('harga_sewa');
            $table->integer('denda')->nullable();
            $table->integer('total_bayar');
            $table->string('jenis')->nullable();
            $table->string('status')->default('menunggu');
            $table->string('komentar')->nullable();
            $table->string('image');
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
        Schema::dropIfExists('pembayarans');
    }
};
