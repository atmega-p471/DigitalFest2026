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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->date('period_from');
            $table->date('period_to');
            $table->decimal('total_amount', 12, 2);
            $table->string('currency', 3)->default('RUB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
