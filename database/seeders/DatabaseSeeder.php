<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seederを使用する場合、ここでSeederクラスを読みこむ
        $this->call([
            MEventSeeder::class,
            MEventPositionSeeder::class,
            TeamSeeder::class,
            SexSeeder::class,
            AthleteSeeder::class,
            PlayerPositionSeeder::class,
            MBodyPartSeeder::class,
            MInjuryNameSeeder::class,
        ]);
    }
}
