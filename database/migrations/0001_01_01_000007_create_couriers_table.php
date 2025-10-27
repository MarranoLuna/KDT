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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->boolean("status");
            $table->date("start_date");
            $table->string("dni", 8);
            $table->string('dni_frente_path')->nullable();
            $table->string('dni_dorso_path')->nullable();
            $table->boolean("is_validated");
            $table->decimal("balance", 9, 2)->default(0.00);
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->decimal('area')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
