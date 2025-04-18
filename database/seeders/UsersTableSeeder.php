<?php

/**
 * Users Table Seeder
 * -----------------------------------------------------------------------------
 * Llena la tabla 'users' con datos de prueba.
 *
 * @author Ronald Bello <ronaldbello2@gmail.com>
 */

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Users Table Seeder
 * -----------------------------------------------------------------------------
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run
     * -------------------------------------------------------------------------
     */
    public function run(): void
    {
        User::insert(
            [
                [
                    'name' => env('ADMIN_USER'),
                    'email' => env('ADMIN_EMAIL'),
                    'password' => Hash::make(env('ADMIN_PASS')),
                ],
            ]
        );
    }
}
