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
                'description' => 'ランダムに置く',
                'description_en' => 'Put randomly',
            ],
            [
                'name' => 'Brain2',
                'description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'description_en' => 'Put in the corner if possible, otherwise put randomly',
            ],
            // [
            //     'name' => 'Brain3',
            //     'description' => 'Brain3 description',
            // ],
            // [
            //     'name' => 'Brain4',
            //     'description' => 'Brain4 description',
            // ]
        ]);
    }
}
