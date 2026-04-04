<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status 
            ENUM('pending','tersedia','terjual','ditolak') 
            NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status 
            ENUM('tersedia','terjual','ditolak') 
            NOT NULL DEFAULT 'tersedia'");
    }
};