<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the followers table.
 * 
 * This migration creates the followers table for storing
 * and managing followers-related data in the application.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the followers table.
     * 
     * This method creates the followers table with its columns
     * and relationships to store and manage followers data.
     */
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'user_id')->constrained('users');
            $table->foreignIdFor(User::class,'follower_id')->constrained('users');
            $table->unique(['user_id','follower_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the followers table.
     * 
     * This method drops the followers table, removing all
     * stored followers data from the database.
     * 
     * Note: All followers data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
