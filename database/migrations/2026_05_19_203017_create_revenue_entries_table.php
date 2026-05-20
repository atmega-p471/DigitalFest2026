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
            $table->decimal('expected_amount_rub', 12, 2)->nullable();
            $table->string('currency', 3)->default('RUB');
            $table->string('platform')->default('Yandex Music');
            $table->string('country', 2)->default('RU');
            $table->string('subscription_type')->default('premium');
            $table->integer('streams')->default(0);
            $table->text('source')->nullable();
            $table->decimal('fx_rate_to_rub', 12, 6)->default(1);
            $table->boolean('is_manual_corrected')->default(false);
            $table->timestamps();

            $table->unique(['track_id', 'revenue_date', 'platform', 'country', 'subscription_type'], 'rev_unique_idx');
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
