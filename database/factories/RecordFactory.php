<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $models = ['Brain1', 'Brain2', 'Brain3', 'Brain4'];
        $count_black = mt_rand(0, 64);
        $count_white = 64 - $count_black;
        return [
            'black_model' => $models[mt_rand(0, 3)],
            'white_model' => $models[mt_rand(0, 3)],
            'count_black' => $count_black,
            'count_white' => $count_white,
        ];
    }
}
