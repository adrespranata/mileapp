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
        Schema::create('koli_data', function (Blueprint $table) {
            $table->uuid('koli_id')->primary();
            $table->uuid('connote_id');
            $table->integer('koli_length');
            $table->string('awb_url');
            $table->integer('koli_chargeable_weight');
            $table->integer('koli_width');
            $table->integer('koli_height');
            $table->string('koli_description');
            $table->uuid('koli_formula_id')->nullable();
            $table->integer('koli_volume');
            $table->integer('koli_weight');
            $table->string('koli_code');
            $table->json('koli_surcharge');
            $table->json('koli_custom_field');
            $table->timestamps();

            $table->foreign('connote_id')->references('connote_id')->on('connotes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koli_data');
    }
};
