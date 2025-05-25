<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Administrateur'],
            ['id' => 2, 'name' => 'Utilisateur'],
            ['id' => 3, 'name' => 'Super Administrateur'],
        ]);
    }
}
