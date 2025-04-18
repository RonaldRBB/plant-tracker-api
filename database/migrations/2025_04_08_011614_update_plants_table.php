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
        Schema::table('plants', function (Blueprint $table) {
            // Eliminar columnas existentes
            $table->dropColumn([
                'spring_watering_frequency',
                'summer_watering_frequency',
                'autumn_watering_frequency',
                'winter_watering_frequency',
                'minimum_light_fc',
                'ideal_light_fc',
                'fertilization_period',
                'spring_fertilization',
                'summer_fertilization',
                'autumn_fertilization',
                'winter_fertilization'
            ]);

            // Agregar nueva columna DLI
            $table->integer('dli')->nullable()->after('common_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            // Eliminar la columna DLI
            $table->dropColumn('dli');

            // Restaurar columnas eliminadas
            $table->integer('spring_watering_frequency')->nullable()->comment('every x days');
            $table->integer('summer_watering_frequency')->nullable()->comment('every x days');
            $table->integer('autumn_watering_frequency')->nullable()->comment('every x days');
            $table->integer('winter_watering_frequency')->nullable()->comment('every x days');
            $table->integer('minimum_light_fc')->nullable()->comment('foot candle');
            $table->integer('ideal_light_fc')->nullable()->comment('foot candle');
            $table->integer('fertilization_period')->comment('every x weeks');
            $table->boolean('spring_fertilization')->default(false);
            $table->boolean('summer_fertilization')->default(false);
            $table->boolean('autumn_fertilization')->default(false);
            $table->boolean('winter_fertilization')->default(false);
        });
    }
};
