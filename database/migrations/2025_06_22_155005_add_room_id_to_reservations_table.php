<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable()->change();
        });

        DB::table('reservations')
            ->whereNotIn('room_id', DB::table('rooms')->pluck('id'))
            ->update(['room_id' => null]);
    }

    /**
     * Reverse the migrations.Schema::table('reservations', fn (Blueprint $table) =>
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('room_id');
        });
    }
};
