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
        // 初期データ作成
        MEvent::create([
            'id' => 1,
            'event_name' => 'サッカー',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        MEvent::create([
            'id' => 2,
            'event_name' => 'ラグビー',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
