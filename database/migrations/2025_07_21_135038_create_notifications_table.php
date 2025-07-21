<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the notifications table.
 * 
 * This migration creates the notifications table for storing
 * and managing notifications-related data in the application.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the notifications table.
     * 
     * This method creates the notifications table with its columns
     * and relationships to store and manage notifications data.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the notifications table.
     * 
     * This method drops the notifications table, removing all
     * stored notifications data from the database.
     * 
     * Note: All notifications data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
