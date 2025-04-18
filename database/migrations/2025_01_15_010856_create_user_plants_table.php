<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_plants',
            function (Blueprint $table) {
                $table->bigInteger('id')->default(DB::raw("nextval('global_id_seq')"))->primary();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('plant_id')->constrained('plants');
                $table->string('nickname')->nullable();
                $table->string('location')->nullable();
                $table->text('notes')->nullable();
                $table->date('acquired_date')->nullable();
                $table->date('death_date')->nullable();
                $table->boolean('mycorrhiza')->default(false);
                $table->date('mycorrhiza_date')->nullable();
                $table->timestamps();
            }
        );
    }
    public function down(): void
    {
        Schema::dropIfExists('user_plants');
    }
};

