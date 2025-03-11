<?php

namespace Database\Seeders;

use App\Models\MEvent;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        // 初期データ作成
        MEvent::create([
            'id' => 1,
            'event_name' => 'サッカー',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        MEvent::create([
            'id' => 2,
            'event_name' => '陸上競技',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
