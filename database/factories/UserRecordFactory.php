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
        $user_discs = mt_rand(0, 64);
        $brain_discs = 64 - $user_discs;
        return [
            'user_id' => mt_rand(1, 10),
            'brain_id' => mt_rand(1, 5),
            'user_discs' => $user_discs,
            'brain_discs' => $brain_discs,
            'is_first' => fake()->boolean(),
        ];
    }
}
