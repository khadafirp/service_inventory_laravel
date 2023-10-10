<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('id_kategori');
            $table->string('nama_barang');
            $table->integer('stok_barang');
            $table->string('harga_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_barangs');
    }
};
