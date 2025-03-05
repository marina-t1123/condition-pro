<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'team_name' => fake()->name(),
            // 'memo' => fake()->realText(30),
            // 'created_at' => Carbon::now(),
            // 'updated_at' => Carbon::now()
            'team_name' => Str::random(10),
            'memo' => Str::random(30),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
