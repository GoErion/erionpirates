<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to optimize SQLite database performance settings.
 *
 * This migration configures two important SQLite PRAGMA settings:
 * 1. journal_mode = WAL (Write-Ahead Logging): Improves concurrent access
 * 2. synchronous = NORMAL: Balances data safety with performance
 *
 * These settings only apply when using SQLite as the database driver.
 *
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to optimize SQLite database performance.
     *
     * This method:
     * 1. Checks if the application is using SQLite as the database driver
     * 2. Sets journal_mode to WAL (Write-Ahead Logging), which allows readers
     *    to access the database while a writer is active, improving concurrency
     * 3. Sets synchronous to NORMAL, which provides a balance between data safety
     *    and performance by syncing at critical moments but not for every change
     *
     * These optimizations can significantly improve performance for SQLite databases,
     * especially under concurrent access patterns.
     */
    public function up(): void
    {
        if (config('database.default') === 'sqlite')
        {
            DB::statement('PRAGMA journal_mode = WAL');
            DB::statement('PRAGMA synchronous = NORMAL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * This method is intentionally empty because:
     * 1. The performance optimizations don't need to be reversed
     * 2. Reverting to the default SQLite settings would degrade performance
     * 3. These settings don't affect data integrity or schema structure
     *
     * If needed, specific PRAGMA settings could be reset in a separate migration.
     */
    public function down(): void
    {
        // No action needed to reverse these performance optimizations
    }
};
