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
                'ja_description' => 'ランダムに置く',
                'en_description' => 'Put randomly',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Brain2',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'Admin',
            ],
            [
                'name' => 'Brain3',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'AAA',
            ],
            [
                'name' => 'Brain4',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'BBB',
            ],
            [
                'name' => 'Brain5',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'CCC',
            ],
        ]);
    }
}
