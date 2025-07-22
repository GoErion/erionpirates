<?php

use App\Models\Hashtag;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the hashtags table.
 *
 * This migration creates the hashtags table for storing
 * and managing hashtags-related data in the application.
 *
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the hashtags table.
     *
     * This method creates the hashtags table with its columns
     * and relationships to store and manage hashtags data.
     */
    public function up(): void
    {
        Schema::create('hashtags', function (Blueprint $table)
        {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();

            $table->rawIndex('name collate nocase','name_collate_nocase');
        });

        Schema::create('hashtag_question',function (Blueprint $table)
        {
            $table->id();
            $table->foreignIdFor(Hashtag::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();
            $table->unique(['hashtag_id','question_id']);
        });
    }

    /**
     * Reverse the migrations by dropping the hashtags table.
     *
     * This method drops the hashtags table, removing all
     * stored hashtags data from the database.
     *
     * Note: All hashtags data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('hashtags');
    }
};
