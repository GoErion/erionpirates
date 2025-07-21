<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the likes table.
 * 
 * This migration creates the likes table for storing
 * and managing likes-related data in the application.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the likes table.
     * 
     * This method creates the likes table with its columns
     * and relationships to store and manage likes data.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table)
        {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();
            $table->unique(['user_id','question_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the likes table.
     * 
     * This method drops the likes table, removing all
     * stored likes data from the database.
     * 
     * Note: All likes data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
