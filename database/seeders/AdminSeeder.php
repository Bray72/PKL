<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;    

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::updateOrCreate(
            ['email' => 'superadmin@itsa.com'],
            [
                'role_id' => 1,
                'name' => 'Super Admin ITSA',
                'password' => bcrypt('12345678'),
                'opd' => 'ITSA',
            ]
        );

        // Admin 1
        User::updateOrCreate(
            ['email' => 'admin1@itsa.com'],
            [
                'role_id' => 2,
                'name' => 'Admin 1 ITSA',
                'password' => bcrypt('12345678'),
                'opd' => 'ITSA',
            ]
        );

        // Admin 2
        User::updateOrCreate(
            ['email' => 'admin2@itsa.com'],
            [
                'role_id' => 3,
                'name' => 'Admin 2 ITSA',
                'password' => bcrypt('12345678'),
                'opd' => 'ITSA',
            ]
        );

        // User OPD
        User::updateOrCreate(
            ['email' => 'soetomo@opd.com'],
            [
                'role_id' => 4,
                'name' => 'RS SOETOMO',
                'password' => bcrypt('12345678'),
                'opd' => 'RS SOETOMO',
            ]
        );
    }
}
