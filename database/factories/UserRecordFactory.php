<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Brain;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRecord>
 */
class UserRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_id = [1, 2, 3];
        $brain_id = [1, 2];
        $results = ['win', 'lose', 'draw'];
        return [
            'user_id' => $user_id[mt_rand(0, 2)],
            'brain_id' => $brain_id[mt_rand(0, 1)],
            'result' => $results[mt_rand(0, 2)],
        ];
    }
}
