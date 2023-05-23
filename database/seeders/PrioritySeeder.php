<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            'name' => 'Critical',
        ]);

        DB::table('priorities')->insert([
            'name' => 'High',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Medium',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Low',
        ]);
    }
}
