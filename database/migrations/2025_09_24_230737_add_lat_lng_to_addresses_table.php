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
         Schema::table('addresses', function (Blueprint $table) {
            // Agregamos las columnas después de 'user_id'
            $table->decimal('lat', 10, 7)->after('user_id');
            $table->decimal('lng', 10, 7)->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
             $table->dropColumn(['lat', 'lng']);
        });
    }
};
