<?php

namespace Database\Seeders;

use App\Models\Sex;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Sex::insert([
            [
                'id' => 1,
                'sex_name' => '男性',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'sex_name' => '女性',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'sex_name' => 'その他',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
