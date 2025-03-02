<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::factory()->create([
            'team_name' => '東京大学',
            'memo' => '契約期間1年毎'
        ]);
    }
}
