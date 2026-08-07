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
        Schema::create('compensation_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['salary', 'commission', 'salary_commission'])->default('salary_commission');
            $table->decimal('base_salary', 10, 2)->default(0);
            $table->enum('commission_type', ['percent_sale', 'percent_margin', 'fixed_per_tier'])->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();
            // {"3star": 3000, "4star": 5000, "5star": 8000, "visa_only": 500}
            $table->json('tier_rates')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compensation_plans');
    }
};
