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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('alternative_phone')->nullable();
            $table->string('land_phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('city_id');
            $table->integer('district_id');
            $table->text('address');
            $table->integer('product_id');
            $table->integer('product_color_id');
            $table->string('imei');
            $table->integer('warranty_status_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->integer('fault_category_id');
            $table->text('fault_detail')->nullable();
            $table->integer('service_priority_id')->nullable();
            $table->integer('referance_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('process_status_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
