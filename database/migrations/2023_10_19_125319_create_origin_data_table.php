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
        Schema::create('origin_data', function (Blueprint $table) {
            $table->id();

            $table->integer("organization_id");
            $table->string("location_id");

            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('customer_address_detail')->nullable();
            $table->string('customer_zip_code');
            $table->string('zone_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origin_data');
    }
};
