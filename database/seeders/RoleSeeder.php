<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['superadmin', 'admin1', 'admin2', 'opd'] as $name) {
            DB::table('roles')->updateOrInsert(
                ['name' => $name],
                ['name' => $name],
                ['name' => $name],
                ['name' => $name]
            );
        }
    }
}
