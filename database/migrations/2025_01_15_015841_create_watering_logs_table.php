<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watering_logs', function (Blueprint $table) {
            $table->bigInteger('id')->default(DB::raw("nextval('global_id_seq')"))->primary();
            $table->foreignId('user_plant_id')->constrained('user_plants')->onDelete('cascade');
            $table->date('watering_date');
            $table->enum('watering_method', ['immersion', 'surface', 'spraying']);
            $table->boolean('with_fertilizer')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('watering_logs');
    }
};

