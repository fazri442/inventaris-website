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
        Schema::create('datapusats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tool')->unique();
            $table->string('nama_tool');
            $table->string('foto');
            $table->integer('stok');
            $table->string('deskripsi');
            $table->string('lokasi');
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
        Schema::dropIfExists('datapusats');
    }
};
