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
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_tool');
            $table->integer('jumlah');
            $table->timestamps();
            $table->foreign('id_peminjaman')->references('id')->on('peminjamans')->onDelete('cascade');
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
        Schema::dropIfExists('detail_peminjamans');
    }
};
