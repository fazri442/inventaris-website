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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pinjam')->unique();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->string('status');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id_tim');
            $table->unsignedBigInteger('id_tool');
            $table->timestamps();
            $table->foreign('id_tim')->references('id')->on('tims')->onDelete('cascade');
            $table->foreign('id_tool')->references('id')->on('datapusats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Peminjaman');
    }
};
