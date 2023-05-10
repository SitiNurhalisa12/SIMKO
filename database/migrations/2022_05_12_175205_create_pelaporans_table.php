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
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id');
            $table->foreignId('user_id');
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('status')->default('menunggu');
            $table->string('jenis')->default('kerusakan');
            $table->string('keterangan')->nullable();
            $table->string('informasi')->nullable();
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
        Schema::dropIfExists('pelaporans');
    }
};
