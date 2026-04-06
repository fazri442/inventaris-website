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
        Schema::create('barangkeluars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tool');
            $table->integer('jumlah');
            $table->date('tanggal_keluar');
            $table->string('keterangan');
            $table->string('lokasi');
            $table->unsignedBigInteger('nama_tim');
            $table->unsignedBigInteger('id_tool');
            $table->timestamps();
            $table->foreign('id_tool')->references('id')->on('datapusats')->ondelete('cascade');
            $table->foreign('nama_tim')->references('id')->on('tims')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangkeluars');
    }
};
