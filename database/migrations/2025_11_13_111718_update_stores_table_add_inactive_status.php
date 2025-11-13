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
        // Update status column to include 'inactive'
        DB::statement("ALTER TABLE stores MODIFY status VARCHAR(20) DEFAULT 'pending' COMMENT 'pending|approved|rejected|inactive'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE stores MODIFY status VARCHAR(20) DEFAULT 'pending' COMMENT 'pending|approved|rejected'");
    }
};
