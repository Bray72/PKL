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
        User::updateOrCreate(
            [
                'email' => 'admin@itsa.test',
            ],
            [
                'role_id' => 1,
                'name' => 'Admin ITSA',
                'password' => 'password123',
                'instansi' => 'ITSA',
            ]
        );
    }
}
