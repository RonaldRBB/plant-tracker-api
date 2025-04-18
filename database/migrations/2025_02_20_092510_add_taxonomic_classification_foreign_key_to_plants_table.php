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
            $table->bigInteger('taxonomic_classification_id')->nullable();
            $table->foreign('taxonomic_classification_id')
                ->references('id')
                ->on('taxonomic_classifications')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->dropForeign(['taxonomic_classification_id']);
            $table->dropColumn('taxonomic_classification_id');
        });
    }
};
