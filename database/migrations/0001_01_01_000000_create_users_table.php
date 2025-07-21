<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Initial migration that creates the core user authentication tables.
 *
 * This migration creates three tables:
 * - users: Stores user account information and profile data
 * - password_reset_tokens: Manages password reset functionality
 * - sessions: Tracks user sessions for authentication
 *
 * @created 0001-01-01
 */
return new class extends Migration
{
    /**
     * Run the migrations to create the users, password_reset_tokens, and session tables.
     *
     * The user's table includes columns for:
     * - Basic profile information (name, username, bio, email)
     * - Avatar management (avatar path, upload status, update timestamp)
     * - User statistics (view count)
     * - User preferences and settings
     * - Authentication data (password, remember token)
     * - Verification status
     *
     * The password_reset_tokens table stores tokens for password reset functionality.
     *
     * The session table tracks active user sessions with IP and user agent information.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('bio')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->boolean('is_uploaded_avatar')->default(false)->avatar_updated_at();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('avatar_updated_at')->nullable();
            $table->json('links_sort')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('prefers_anonymous_questions')->default(true);
//            $table->string('timezone')->nullable();
            $table->string('mail_preference_time')->default('daily');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_company_verified')->default(false);
            $table->string('github_username')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table)
        {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table)
        {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations by dropping all tables created in the up method.
     *
     * This method drops the following tables in order:
     * - users: The main users table
     * - password_reset_tokens: The table for password-reset functionality
     * - sessions: The table for tracking user sessions
     *
     * Note: All data in these tables will be permanently lost when this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
