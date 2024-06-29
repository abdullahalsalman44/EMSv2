<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'name'=>'Wedding ceremony',
          ]);

          DB::table('events')->insert([
              'name'=>'Birthday party',
            ]);

            DB::table('events')->insert([
              'name'=>'Birth party',
            ]);

            DB::table('events')->insert([
                'name'=>'Graduation party',
              ]);
    }
}
