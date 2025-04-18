<?php

/**
 * Create Global Id Sequences Table
 * -----------------------------------------------------------------------------
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Up
     * -------------------------------------------------------------------------
     * Corre la migración.
     */
    public function up()
    {
        DB::statement('CREATE SEQUENCE IF NOT EXISTS global_id_seq;');
    }
    /**
     * Down
     * -------------------------------------------------------------------------
     * Reversa la migración.
     */
    public function down()
    {
        DB::statement('DROP SEQUENCE IF EXISTS global_id_seq;');
    }
};
