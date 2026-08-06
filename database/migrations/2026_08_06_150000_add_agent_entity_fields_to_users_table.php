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
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable()->after('name');
            $table->string('phone')->nullable()->after('designation');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('languages')->nullable()->after('whatsapp');
            $table->string('specialization')->nullable()->after('languages');
            $table->string('photo')->nullable()->after('specialization');
            $table->boolean('is_active')->default(true)->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['designation', 'phone', 'whatsapp', 'languages', 'specialization', 'photo', 'is_active']);
        });
    }
};
