<?php

namespace Database\Seeders;

use App\Models\MBodyPart;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MBodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 部位マスタ登録データ
        MBodyPart::insert([
            [
                'id' => 1,
                'body_part_name' => '頭部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'body_part_name' => '頸部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'body_part_name' => '肩関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'body_part_name' => '上腕部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'body_part_name' => '肘関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'body_part_name' => '前腕部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 7,
                'body_part_name' => '手関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 8,
                'body_part_name' => '指部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 9,
                'body_part_name' => '胸部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 10,
                'body_part_name' => '腰部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 11,
                'body_part_name' => '背部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 12,
                'body_part_name' => '骨盤部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 13,
                'body_part_name' => '股関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 14,
                'body_part_name' => '大腿部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 15,
                'body_part_name' => '膝関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 16,
                'body_part_name' => '下腿部',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 17,
                'body_part_name' => '足関節',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 18,
                'body_part_name' => '足部',
                'create_at' => $now,
                'updated_at' => $now
            ]

        ]);
    }
}
