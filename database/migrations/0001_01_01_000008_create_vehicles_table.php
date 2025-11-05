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
        Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('model', 50)->nullable();
        $table->string('color', 20);
        $table->string('registration_plate', 10)->nullable();
        $table->boolean('is_validated')->default(false);
        $table->foreignId('vehicle_type_id')->constrained();
        $table->foreignId('motorcycle_brand_id')->nullable()->constrained();
        $table->foreignId('bicycle_brand_id')->nullable()->constrained();
        $table->foreignId('courier_id')->constrained();
        $table->timestamps();
    }
);}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
