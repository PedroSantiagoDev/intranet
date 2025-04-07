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
            $table->string('sender_name', 250);
            $table->string('street', 226);
            $table->string('number', 36)->nullable();
            $table->string('complement', 36)->nullable();
            $table->string('neighborhood', 72)->nullable();
            $table->string('city', 72);
            $table->char('state', 2);
            $table->char('postal_code', 8);
            $table->char('matrix_code', 10)->unique();
            $table->char('contract_number', 10);
            $table->char('postage_card', 10);
            $table->char('administrative_number', 10);
            $table->char('posting_unit', 10);
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
