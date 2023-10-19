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
        Schema::create('connotes', function (Blueprint $table) {
            $table->uuid('connote_id')->primary();
            $table->integer('connote_number');
            $table->string('connote_service');
            $table->decimal('connote_service_price', 10, 2);
            $table->decimal('connote_amount', 10, 2);
            $table->string('connote_code');
            $table->string('connote_booking_code')->nullable();
            $table->integer('connote_order');
            $table->string('connote_state');
            $table->integer('connote_state_id');
            $table->string('zone_code_from');
            $table->string('zone_code_to');
            $table->decimal('surcharge_amount', 10, 2)->nullable();
            $table->uuid('transaction_id');
            $table->decimal('actual_weight', 10, 2);
            $table->decimal('volume_weight', 10, 2);
            $table->decimal('chargeable_weight', 10, 2);
            $table->string("location_id");
            $table->integer("organization_id");
            $table->string('connote_total_package');
            $table->decimal('connote_surcharge_amount', 10, 2);
            $table->string('connote_sla_day');
            $table->string('location_name');
            $table->string('location_type');
            $table->string('source_tariff_db');
            $table->string('id_source_tariff');
            $table->string('pod')->nullable();
            $table->json('history');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connote');
    }
};
