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
        Schema::create('revenue_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();
            $table->date('revenue_date');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('RUB');
            $table->text('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_entries');
    }
};
