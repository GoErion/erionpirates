<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the questions table.
 *
 * This migration creates the questions table for storing
 * and managing questions-related data in the application.
 *
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the questions table.
     *
     * This method creates the questions table with its columns
     * and relationships to store and manage questions data.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->foreignId('root_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignIdFor(User::class, 'from_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'to_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('pinned')->default(false);

            $table->text('content');
            $table->text('answer')->nullable();
            $table->timestamp('answer_created_at')->nullable();
            $table->timestamp('answer_updated_at')->nullable();
            $table->boolean('anonymously')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_ignored')->default(false);
            $table->boolean('is_reported')->default(false);
            $table->index('from_id');
            $table->index('to_id');

            $table->timestamps();
        });

        DB::statement('UPDATE questions SET answer_updated_at = updated_at WHERE answer_created_at < updated_at');

        Question::query()
            ->whereNull('parent_id')
            ->with('children')
            ->each(function (Question $question): void
            {
                $this->updateRootId($question->children, $question->id);
            });
    }

    private function updateRootId(Collection $questions, string $rootId): void
    {
        if ($questions->isEmpty()) {
            return;
        }

        $questions->each(function (Question $question) use ($rootId): void {
            $question->load('children');
            DB::table('questions')->where('id', $question->id)->update([
                'root_id' => $rootId,
            ]);
            $this->updateRootId($question->children, $rootId);
        });
    }

    /**
     * Reverse the migrations by dropping the questions table.
     *
     * This method drops the questions table, removing all
     * stored questions data from the database.
     *
     * Note: All questions data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
