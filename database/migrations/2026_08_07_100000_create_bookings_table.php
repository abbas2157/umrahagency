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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();
            // Nullable — a booking can exist even if the originating inquiry is
            // later deleted; the sale record must outlive the lead record.
            $table->foreignId('inquiry_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('package_tier', ['3star', '4star', '5star', 'visa_only'])->default('3star');
            $table->decimal('total_price', 12, 2);
            // For percent_margin commission — nullable since most agencies won't
            // track cost price at all, and the plan type they choose decides
            // whether this ever gets read.
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->enum('status', ['active', 'cancelled'])->default('active');
            $table->date('booked_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
