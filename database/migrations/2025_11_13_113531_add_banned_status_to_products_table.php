<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUM to include 'banned' status
        DB::statement("ALTER TABLE products MODIFY status VARCHAR(20) DEFAULT 'active' COMMENT 'active|inactive|banned'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY status VARCHAR(20) DEFAULT 'active' COMMENT 'active|inactive'");
    }
};
