<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('postal_code', 8);
            $table->string('street', 226);
            $table->string('number', 36)->nullable();
            $table->string('complement', 36)->nullable();
            $table->string('neighborhood', 72)->nullable();
            $table->string('city', 72);
            $table->char('state', 2);
            $table->char('phone', 11)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
