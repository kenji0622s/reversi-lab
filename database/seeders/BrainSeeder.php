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
                'created_by' => null,
            ],
            [
                'ja_name' => 'ブレイン2',
                'en_name' => 'Brain2',
                'ja_description' => '角に置ける場合は角に置く',
                'en_description' => 'Put in the corner if possible',
                'created_by' => null,
            ],
            [
                'ja_name' => 'ブレイン3',
                'en_name' => 'Brain3',
                'ja_description' => '角に置ける場合は角に置く<br>角の隣にはできるだけ置かない',
                'en_description' => 'Put in the corner if possible<br>Avoid around the corner',
                'created_by' => null,
            ],
            [
                'ja_name' => 'ブレイン4',
                'en_name' => 'Brain4',
                'ja_description' => '角に置ける場合は角に置く<br>角の周りの隣に置ける場合は、角の周りの隣に置く<br>角に置けない場合は、ランダムに置く<br>角の隣にはできるだけ置かない',
                'en_description' => 'Put in the corner if possible<br>Put in the next to the corner if possible<br>Put randomly if not possible<br>Avoid around the corner',
                'created_by' => null,
            ],
            [
                'ja_name' => 'ブレイン5',
                'en_name' => 'Brain5',
                'ja_description' => '角に置ける場合は角に置く<br>角に置けない場合は、ランダムに置く<br>角の隣にはできるだけ置かない',
                'en_description' => 'Put in the corner if possible<br>Put randomly if not possible<br>Avoid around the corner',
                'created_by' => null,
            ],
        ]);
    }
}
