<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->boolean('approved')->default(false); // admin moderation
            $table->timestamps();

            $table->unique(['user_id', 'product_id']); // one review per user per product
            $table->index('approved');
        });

        Schema::create('guest_book', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('message');
            $table->boolean('approved')->default(false); // admin moderation
            $table->timestamps();

            $table->index('approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('guest_book');
    }
};
