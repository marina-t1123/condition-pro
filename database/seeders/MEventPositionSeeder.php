<?php

namespace Database\Seeders;

use App\Models\MEventPosition;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MEventPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 初期データ作成
        MEventPosition::insert([
            [
                'id' => 1,
                'm_event_id' => 1,
                'event_position_name' => 'ゴールキーパー',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'm_event_id' => 1,
                'event_position_name' => 'フォワード',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'm_event_id' => 2,
                'event_position_name' => '走高跳び',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'm_event_id' => 2,
                'event_position_name' => '円盤投げ',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

    }
}
