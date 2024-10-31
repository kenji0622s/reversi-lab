<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrainRecord>
 */
class BrainRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $brain_id = mt_rand(1, 5);
        $opponent_id = mt_rand(1, 5);
        if ($brain_id === 1 && $opponent_id === 1) {
            $opponent_id = mt_rand(2, 5);
        }
        $brain_discs = mt_rand(0, 64);
        $opponent_discs = 64 - $brain_discs;
        return [
            'brain_id' => $brain_id,
            'opponent_id' => $opponent_id,
            'brain_discs' => $brain_discs,
            'opponent_discs' => $opponent_discs,
            'is_first' => fake()->boolean(),
        ];
    }
}
