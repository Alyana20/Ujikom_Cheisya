<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');
            $table->string('nama');
            $table->string('kategori')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable(); // Tambah kolom gambar
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
