<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AthleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Athlete::insert([
            [
                'id' => 1,
                'team_id' => 1,
                'sex_id' => 1,
                'name' => '高橋和希',
                'birthday' => Carbon::createFromDate(2005, 8, 23),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'team_id' => 1,
                'sex_id' => 1,
                'name' => '中村悠一',
                'birthday' => Carbon::createFromDate(2006, 5, 13),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'team_id' => 2,
                'sex_id' => 1,
                'name' => '田口はじめ',
                'birthday' => Carbon::createFromDate(2005, 8, 23),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'team_id' => 3,
                'sex_id' => 2,
                'name' => '木村綾',
                'birthday' => Carbon::createFromDate(2006, 10, 1),
                'memo' => '貧血気味。病院通院。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'team_id' => 3,
                'sex_id' => 1,
                'name' => '田中圭一',
                'birthday' => Carbon::createFromDate(2005, 4, 16),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'team_id' => 4,
                'sex_id' => 1,
                'name' => '河村克樹',
                'birthday' => Carbon::createFromDate(2004, 12, 3),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'team_id' => 4,
                'sex_id' => 2,
                'name' => '田村佳奈',
                'birthday' => Carbon::createFromDate(2004, 7, 25),
                'memo' => '既往歴等は特になし。喘息で病院に通院している。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
