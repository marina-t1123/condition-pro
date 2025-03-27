<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('player_position')->insert([
            'athlete_id' => 1,
            'm_event_position_id' => 1
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 2,
            'm_event_position_id' => 2
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 3,
            'm_event_position_id' => 2
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 4,
            'm_event_position_id' => 3
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 4,
            'm_event_position_id' => 4
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 5,
            'm_event_position_id' => 5
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 5,
            'm_event_position_id' => 6
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 6,
            'm_event_position_id' => 5
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 6,
            'm_event_position_id' => 7
        ]);

        DB::table('player_position')->insert([
            'athlete_id' => 7,
            'm_event_position_id' => 8
        ]);
    }
}
