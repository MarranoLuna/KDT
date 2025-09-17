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
        Schema::create('addresses', function (Blueprint $table) {
        $table->id();
        $table->string('street', 30);
        $table->string('number', 30);
        $table->string('intersection', 30)->nullable();
        $table->char('floor', 1)->nullable();
        $table->string('department', 3)->nullable();
        $table->unsignedBigInteger('user_id');
        // Clave foránea
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->timestamps();
    });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
