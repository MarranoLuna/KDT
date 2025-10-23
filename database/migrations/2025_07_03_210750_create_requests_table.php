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
       Schema::create('requests', function (Blueprint $table) {
        $table->id();
        $table->string('title', 128);
        $table->string('description');
        $table->string('payment_method', 30);
        $table->foreignId('user_id')->constrained();

        
        $table->foreignId('origin_address_id')->constrained('addresses');
        $table->foreignId('destination_address_id')->constrained('addresses');
        $table->foreignId('request_status_id')->constrained('request_statuses');
        $table->unsignedBigInteger('address_id')->nullable();
        $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
