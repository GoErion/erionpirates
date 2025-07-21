<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to optimize database settings and performance.
 * 
 * This migration applies various optimizations to improve
 * database performance and efficiency.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to optimize database settings.
     * 
     * This method applies various database optimizations
     * to improve performance and efficiency.
     */
    public function up(): void
    {
        if (config('database.default') === 'sqlite')
        {
            DB::statement('PRAGMA journal_mode = WAL');
            DB::statement('PRAGMA synchronous = NORMAL');
            DB::statement('PRAGMA page_size = 32768;');
            DB::statement('PRAGMA cache_size = -20000;');
            DB::statement('PRAGMA auto_vacuum = incremental;');
        }
    }

    /**
     * Reverse the migrations.
     */
    /**
     * Reverse the migrations.
     * 
     * This method is intentionally minimal as most database
     * optimizations don't need to be reversed or would
     * negatively impact performance if reversed.
     */
    public function down(): void
    {
        //
    }
};
