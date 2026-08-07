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
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('base_salary', 10, 2)->default(0);
            $table->decimal('commission', 10, 2)->default(0);
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('advance_deduct', 10, 2)->default(0);
            $table->decimal('other_deduct', 10, 2)->default(0);
            $table->decimal('tax_deduct', 10, 2)->default(0);
            $table->decimal('net_payable', 10, 2);
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['payroll_id', 'agent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
