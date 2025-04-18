<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plants_images', function (Blueprint $table) {
            $table->bigInteger('id')->default(DB::raw("nextval('global_id_seq')"))->primary();
            $table->foreignId('user_plant_id')->constrained('user_plants');
            $table->text('notes')->nullable();
            $table->string('image_path');
            $table->date('captured_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plants_images');
    }
};
