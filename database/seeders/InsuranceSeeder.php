<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insurances')->insert([
            'name'=>'Visitors',
            'description'=>'Type of insurance'
        ]);
        DB::table('insurances')->insert([
            'name'=>'Students',
            'description'=>'Type of insurance'
        ]);
        DB::table('insurances')->insert([
          'name'=>'Long Stay',
          'description'=>'Type of insurance'
      ]);
    }   
}
