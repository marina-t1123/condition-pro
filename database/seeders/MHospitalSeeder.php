<?php

namespace Database\Seeders;

use App\Models\MHospital;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MHospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        MHospital::insert([
            [
                'id' => 1,
                'hospital_name' => '船橋整形外科クリニック',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'hospital_name' => '亀田総合病院スポーツ医学科',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'hospital_name' => '筑波大学整形外科',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
