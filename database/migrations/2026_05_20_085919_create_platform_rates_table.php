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
        Schema::create('platform_rates', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('country', 2)->default('RU');
            $table->string('subscription_type')->default('premium');
            $table->decimal('rate_per_stream_rub', 12, 6);
            $table->timestamps();

            $table->unique(['platform', 'country', 'subscription_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_rates');
    }
};
