<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Ajoutez cette ligne

class EmployersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employers')->insert([
            ['name' => 'John Doe', 'position' => 'Manager', 'salary' => 50000.00],
            ['name' => 'Jane Smith', 'position' => 'Developer', 'salary' => 60000.00],
            ['name' => 'Alice Johnson', 'position' => 'Designer', 'salary' => 55000.00],
        ]);
    }
}
