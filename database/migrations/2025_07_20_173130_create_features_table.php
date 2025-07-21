<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Pennant\Migrations\PennantMigration;

return new class extends PennantMigration
{
    /**
     * Run the migrations to create the features table.
     * 
     * This method creates the features table with its columns
     * and relationships to store and manage features data.
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('scope');
            $table->text('value');
            $table->timestamps();
            $table->unique(['name', 'scope']);
        });
    }

    /**
     * Reverse the migrations by dropping the features table.
     * 
     * This method drops the features table, removing all
     * stored features data from the database.
     * 
     * Note: All features data will be permanently lost when
     * this migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
