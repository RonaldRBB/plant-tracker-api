<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->bigInteger('id')->default(DB::raw("nextval('global_id_seq')"))->primary();
            $table->string('scientific_name');
            $table->string('common_name');
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
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
