<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('title_details')->insert([
            'name'=>'Benefits',
        ]);
        DB::table('title_details')->insert([
            'name'=>'Exclusions',
        ]);
        DB::table('title_details')->insert([
            'name'=>'Claims',
        ]);
        DB::table('title_details')->insert([
            'name'=>'FAQ',
        ]);
        DB::table('title_details')->insert([
            'name'=>'Rates',
        ]);
        DB::table('title_details')->insert([
            'name'=>'Downloads',
        ]);
    }
}
