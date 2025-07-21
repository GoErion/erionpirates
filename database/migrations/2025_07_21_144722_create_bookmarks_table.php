<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the bookmarks table.
 * 
 * This migration creates the bookmarks table for storing
 * and managing bookmarks-related data in the application.
 * 
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the bookmarks table.
     * 
     * This method creates the bookmarks table with its columns
     * and relationships to store and manage bookmarks data.
     */
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();
            $table->unique(['user_id','question_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the bookmarks table.
     * 
     * This method drops the bookmarks table, removing all
     * stored bookmarks data from the database.
     * 
     * Note: All bookmarks data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
