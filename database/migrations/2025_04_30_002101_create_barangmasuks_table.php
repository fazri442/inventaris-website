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
        Schema::create('barangmasuks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->integer('jumlah');
            $table->date('tanggal_masuk');
            $table->string('keterangan');
            $table->unsignedBigInteger('id_barang');
            $table->timestamps();
            $table->foreign('id_barang')->references('id')->on('datapusats')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangmasuks');
    }
};
