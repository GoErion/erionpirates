<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the cache-related tables for the application.
 *
 * This migration creates two tables:
 * - cache: Stores cached data with keys, values, and expiration times
 * - cache_locks: Manages distributed locks for the cache system
 *
 * These tables are essential for Laravel's cache functionality, improving
 * application performance by storing frequently accessed data.
 *
 * @created 0001-01-01
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the cache and cache_locks tables.
     *
     * The cache table includes columns for:
     * - key: The unique identifier for the cached item (primary key)
     * - value: The actual cached data stored as mediumText
     * - expiration: The timestamp when the cached item expires
     *
     * The cache_locks table includes columns for:
     * - key: The unique identifier for the lock (primary key)
     * - owner: The identifier of the process that owns the lock
     * - expiration: The timestamp when the lock expires
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table)
        {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table)
        {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations by dropping the cache-related tables.
     *
     * This method drops the following tables in order:
     * - cache: The table storing cached data
     * - cache_locks: The table managing distributed locks
     *
     * Note: Dropping these tables will clear all cached data and locks,
     * which may temporarily impact application performance until the cache
     * is rebuilt.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
