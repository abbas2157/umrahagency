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
        Schema::table('agency_branches', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('city_id');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('email')->nullable()->after('whatsapp');
            $table->string('hours')->nullable()->after('email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('agency_id')
                ->constrained('agency_branches')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('branch_id');
        });

        Schema::table('agency_branches', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'email', 'hours']);
        });
    }
};
