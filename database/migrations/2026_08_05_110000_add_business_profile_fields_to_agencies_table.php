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
        Schema::table('agencies', function (Blueprint $table) {
            // Identity
            $table->string('legal_name')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('logo_path')->nullable();

            // Phone & messaging
            $table->string('phone_local')->nullable();
            $table->string('phone_e164')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->string('landline')->nullable();
            $table->string('best_hours_to_call')->nullable();

            // Email
            $table->string('email_general')->nullable();
            $table->string('email_bookings')->nullable();
            $table->string('email_support')->nullable();

            // Address
            $table->string('address_line')->nullable();
            $table->string('address_area')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable()->default('Pakistan');
            $table->string('maps_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('branch_offices')->nullable();

            // Opening hours
            $table->string('hours_mon_thu')->nullable();
            $table->string('hours_friday')->nullable();
            $table->string('hours_saturday')->nullable();
            $table->string('hours_sunday')->nullable();
            $table->string('hours_public_holidays')->nullable();
            $table->string('timezone')->nullable()->default('Asia/Karachi');

            // Licensing & trust signals
            $table->string('mora_license_no')->nullable();
            $table->string('dts_license_no')->nullable();
            $table->string('iata_no')->nullable();
            $table->string('ntn')->nullable();
            $table->string('memberships')->nullable();
            $table->string('nusuk_registration')->nullable();

            // Social profiles
            $table->string('social_facebook')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_pinterest')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_google_business')->nullable();

            // Service & operations
            $table->text('departure_airports')->nullable();
            $table->text('services_offered')->nullable();
            $table->string('languages_spoken')->nullable();
            $table->string('currency')->nullable()->default('PKR');
            $table->string('payment_methods')->nullable();
            $table->text('deposit_policy')->nullable();
            $table->string('refund_policy_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name', 'founded_year', 'owner_name', 'tagline', 'logo_path',
                'phone_local', 'phone_e164', 'whatsapp', 'phone_secondary', 'landline', 'best_hours_to_call',
                'email_general', 'email_bookings', 'email_support',
                'address_line', 'address_area', 'city', 'province', 'postal_code', 'country', 'maps_url',
                'latitude', 'longitude', 'branch_offices',
                'hours_mon_thu', 'hours_friday', 'hours_saturday', 'hours_sunday', 'hours_public_holidays', 'timezone',
                'mora_license_no', 'dts_license_no', 'iata_no', 'ntn', 'memberships', 'nusuk_registration',
                'social_facebook', 'social_twitter', 'social_instagram', 'social_pinterest', 'social_youtube', 'social_tiktok', 'social_google_business',
                'departure_airports', 'services_offered', 'languages_spoken', 'currency', 'payment_methods', 'deposit_policy', 'refund_policy_url',
            ]);
        });
    }
};
