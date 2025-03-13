<?php

namespace Database\Seeders;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 初期データ作成
        Team::insert([
            [
                'id' => 1,
                'm_event_id' => 1,
                'team_name' => '東京大学サッカー部',
                'memo' => '関東大学サッカーリーグ：２部。',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'm_event_id' => 1,
                'team_name' => '順天堂大学サッカー部',
                'memo' => 'サポート開始:2023年4月から。契約期間1年毎の更新制',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'm_event_id' => 2,
                'team_name' => '神奈川大学陸上部',
                'memo' => '外部コーチとの連携が必要。',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'm_event_id' => 2,
                'team_name' => '順天堂大学陸上部',
                'memo' => 'サポート開始:2023年7月から。試合帯同が主な業務。',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
