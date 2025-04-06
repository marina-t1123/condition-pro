<?php

namespace Database\Seeders;

use App\Models\MInjuryName;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MInjuryNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 傷病名マスタ登録データ
        MInjuryName::insert([
            [
                'id' => 1,
                'injury_name' => '足関節内反捻挫',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'injury_name' => '膝関節内側側副靱帯損傷',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'injury_name' => '脳震盪',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'injury_name' => '手根骨骨折',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'injury_name' => '肩関節脱臼',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'injury_name' => '腰椎椎間板ヘルニア',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
