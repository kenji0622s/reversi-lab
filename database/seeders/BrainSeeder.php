<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brains')->insert([
            [
                'name' => 'Brain1',
                'description' => 'Brain1 description',
            ],
            [
                'name' => 'Brain2',
                'description' => 'Brain2 description',
            ],
            [
                'name' => 'Brain3',
                'description' => 'Brain3 description',
            ],
            [
                'name' => 'Brain4',
                'description' => 'Brain4 description',
            ]
        ]);
    }
}
