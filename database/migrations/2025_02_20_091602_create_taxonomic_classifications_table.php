<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxonomic_classifications', function (Blueprint $table) {
            $table->bigInteger('id')->default(DB::raw("nextval('global_id_seq')"))->primary();
            $table->string('kingdom');
            $table->string('division');
            $table->string('class');
            $table->string('order');
            $table->string('family');
            $table->string('genus');
            $table->timestamps();

            // Agregar índice único compuesto
            $table->unique(['kingdom', 'division', 'class', 'order', 'family', 'genus'], 'taxonomic_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxonomic_classifications');
    }
};

