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
    Schema::create('pengembalians', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('peminjaman_id');
        $table->integer('jumlah_dikembalikan');
        $table->date('tanggal_kembali');
        $table->timestamps();
        $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalians');
    }
};
