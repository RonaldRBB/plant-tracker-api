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
        Schema::table('watering_logs', function (Blueprint $table) {
            $table->dropForeign(['user_plant_id']);
            $table->foreign('user_plant_id')
                ->references('id')
                ->on('user_plants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watering_logs', function (Blueprint $table) {
            $table->dropForeign(['user_plant_id']);
            $table->foreign('user_plant_id')
                ->references('id')
                ->on('user_plants');
        });
    }
};
