<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the pan_analytics table.
 * 
 * This migration creates the pan_analytics table for storing
 * and managing pan_analytics-related data in the application.
 * 
 * @created 2025-07-20
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the pan_analytics table.
     * 
     * This method creates the pan_analytics table with its columns
     * and relationships to store and manage pan_analytics data.
     */
    public function up(): void
    {
        Schema::create('pan_analytics', function (Blueprint $table): void
        {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('impressions')->default(0);
            $table->unsignedBigInteger('hovers')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
        });
    }

    /**
     * Reverse the migrations by dropping the pan_analytics table.
     * 
     * This method drops the pan_analytics table, removing all
     * stored pan_analytics data from the database.
     * 
     * Note: All pan_analytics data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('pan_analytics');
    }
};
