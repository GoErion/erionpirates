<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the links table.
 * 
 * This migration creates the links table for storing
 * and managing links-related data in the application.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the links table.
     * 
     * This method creates the links table with its columns
     * and relationships to store and manage links data.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table)
        {
            $table->id();
            $table->string('description');
            $table->string('url');
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->index('user_id');
            $table->unsignedBigInteger('click_count')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the links table.
     * 
     * This method drops the links table, removing all
     * stored links data from the database.
     * 
     * Note: All links data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
