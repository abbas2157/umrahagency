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
        Schema::create('agent_compensation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('compensation_plans')->cascadeOnDelete();
            $table->date('effective_from');
            // NULL = current. Closed off (set to the day before) when a new
            // plan is assigned — never edited afterward, so past commission
            // calculations always resolve against the plan that was actually
            // in effect at the time, never today's plan.
            $table->date('effective_to')->nullable();
            $table->timestamps();

            $table->index(['agent_id', 'effective_from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_compensation');
    }
};
