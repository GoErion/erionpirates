<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the queue-related tables for the application.
 *
 * This migration creates three tables:
 * - jobs: Stores queued jobs waiting to be processed
 * - job_batches: Manages groups of related jobs as batches
 * - failed_jobs: Records information about jobs that failed to process
 *
 * These tables are essential for Laravel's queue system, enabling background
 * processing, job batching, and failure tracking.
 *
 * @created 0001-01-01
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the jobs, job_batches, and failed_jobs tables.
     *
     * The jobs table includes columns for:
     * - id: The unique identifier for the job
     * - queue: The queue name the job belongs to (indexed for performance)
     * - payload: The serialized job data
     * - attempts: The number of times the job has been attempted
     * - reserved_at: When the job was reserved for processing
     * - available_at: When the job becomes available for processing
     * - created_at: When the job was created
     *
     * The job_batches table includes columns for:
     * - id: The unique identifier for the batch
     * - name: The name of the batch
     * - total_jobs: The total number of jobs in the batch
     * - pending_jobs: The number of jobs still pending
     * - failed_jobs: The number of jobs that failed
     * - failed_job_ids: The IDs of the failed jobs
     * - options: Additional options for the batch
     * - cancelled_at: When the batch was cancelled
     * - created_at: When the batch was created
     * - finished_at: When the batch finished processing
     *
     * The failed_jobs table includes columns for:
     * - id: The unique identifier for the failed job
     * - uuid: A universally unique identifier for the job
     * - connection: The queue connection that was used
     * - queue: The queue the job was on
     * - payload: The serialized job data
     * - exception: The exception that caused the job to fail
     * - failed_at: When the job failed
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table)
        {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table)
        {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations by dropping the queue-related tables.
     *
     * This method drops the following tables in order:
     * - jobs: The table storing queued jobs
     * - job_batches: The table managing job batches
     * - failed_jobs: The table recording failed jobs
     *
     * Note: Dropping these tables will remove all queued, batched, and failed jobs.
     * Any pending background tasks will be lost and will not be processed.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
