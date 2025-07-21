<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to add two_factor_columns columns to the users table.
 * 
 * This migration adds two_factor_columns-related columns to the existing
 * users table to extend its functionality.
 * 
 * @created 2025-07-20
 */
return new class extends Migration
{
    /**
     * Run the migrations to add two_factor_columns columns to the users table.
     * 
     * This method adds new columns related to two_factor_columns
     * to the existing users table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            $table->timestamp('two_factor_confirmed_at')
                ->after('two_factor_recovery_codes')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations by removing the two_factor_columns columns from the users table.
     * 
     * This method removes the two_factor_columns-related columns
     * that were added to the users table.
     * 
     * Note: All data in these columns will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
        });
    }
};
