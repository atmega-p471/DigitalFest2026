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
        Schema::table('artist_track', function (Blueprint $table) {
            $table->decimal('label_percent', 5, 2)->default(0)->after('share_percent');
            $table->decimal('producer_percent', 5, 2)->default(0)->after('label_percent');
            $table->decimal('coauthor_percent', 5, 2)->default(0)->after('producer_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist_track', function (Blueprint $table) {
            $table->dropColumn(['label_percent', 'producer_percent', 'coauthor_percent']);
        });
    }
};
