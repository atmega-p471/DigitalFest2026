<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('revenue_entries', function (Blueprint $table) {
            // Columns moved to initial revenue_entries migration for consistency.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenue_entries', function (Blueprint $table) {
            // No rollback operations required.
        });
    }
};
