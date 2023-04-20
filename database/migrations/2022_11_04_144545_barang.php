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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('satuan_id');
            $table->unsignedBigInteger('jenis_id');
            $table->string('nama_barang');
            $table->integer('stok');
            $table->integer('harga_barang');
            $table->integer('harga_beli');
            $table->timestamps();

            $table->foreign('satuan_id')->references('id')->on('satuan');
            $table->foreign('jenis_id')->references('id')->on('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};