<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
            'password' => 'Passw0rd_'
        ]);
        User::factory()->create([
            'name' => 'karyawan 1',
            'email' => 'karyawan1@example.com',
            'role' => User::ROLE_KARYAWAN,
            'password' => 'karyawan123'
        ]);
        User::factory()->create([
            'name' => 'client 1',
            'email' => 'client1@example.com',
            'role' => User::ROLE_CLIENT,
            'password' => 'client123'
        ]);
    }
}
