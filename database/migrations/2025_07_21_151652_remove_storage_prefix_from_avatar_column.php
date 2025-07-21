<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration to clean up avatar paths in the users table.
 *
 * This migration performs two data cleanup operations:
 * 1. Removes the 'storage/' prefix from avatar paths
 * 2. Sets default avatars to null and updates the is_uploaded_avatar flag
 *
 * This is a data-only migration that doesn't modify the database schema.
 *
 * @created 2025-07-21
 */
return new class extends Migration
{
    /**
     * Run the migrations to clean up avatar paths in the users table.
     *
     * This method:
     * 1. Processes users in batches of 100 to avoid memory issues
     * 2. Removes 'storage/' prefix from avatar paths for better storage handling
     * 3. Sets avatars to null when they use the default avatar image
     * 4. Updates the is_uploaded_avatar flag to false for default avatars
     *
     * The migration uses withoutEvents and withoutTimestamps to prevent
     * unnecessary event triggers and timestamp updates during the process.
     */
    public function up(): void
    {
        User::each(function (User $user): void {
            User::withoutEvents(function () use ($user): void {
                User::withoutTimestamps(function () use ($user): void {
                    if ($user->avatar && str_starts_with((string) $user->avatar, 'storage/')) {
                        $user->update([
                            'avatar' => str_replace('storage/', '', $user->avatar),
                        ]);
                    }

                    if ($user->avatar === asset('img/default-avatar.png') || $user->avatar === 'img/default-avatar.png') {
                        $user->update([
                            'avatar' => null,
                            'is_uploaded_avatar' => false,
                        ]);
                    }
                });
            });
        }, 100);
    }
};
