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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreignId('agency_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('assigned_agent_id')->nullable()->after('agency_id')->constrained('users')->nullOnDelete();
            $table->enum('status', ['new', 'contacted', 'quoted', 'booked', 'lost', 'junk'])->default('new')->after('assigned_agent_id');
            $table->string('lost_reason')->nullable()->after('status');
            $table->timestamp('assigned_at')->nullable()->after('lost_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['status', 'lost_reason', 'assigned_at']);
            $table->dropConstrainedForeignId('assigned_agent_id');
            $table->dropConstrainedForeignId('agency_id');
        });
    }
};
