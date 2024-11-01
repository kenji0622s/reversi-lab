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
                'ja_name' => 'ブレイン1',
                'en_name' => 'Brain1',
                'ja_description' => 'ランダムに置く',
                'en_description' => 'Put randomly',
                'created_by' => 'Admin',
            ],
            [
                'ja_name' => 'ブレイン2',
                'en_name' => 'Brain2',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'Admin',
            ],
            [
                'ja_name' => 'ブレイン3',
                'en_name' => 'Brain3',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'AAA',
            ],
            [
                'ja_name' => 'ブレイン4',
                'en_name' => 'Brain4',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'BBB',
            ],
            [
                'ja_name' => 'ブレイン5',
                'en_name' => 'Brain5',
                'ja_description' => '角に置ける場合は角に置く、角に置けない場合はランダムに置く',
                'en_description' => 'Put in the corner if possible, otherwise put randomly',
                'created_by' => 'CCC',
            ],
        ]);
    }
}
