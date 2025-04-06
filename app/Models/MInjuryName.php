<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MInjuryName extends Model
{
    protected $fillable = ['injury_name'];



    // relasion

    /**
     * 登録済みの全傷病名の取得
     */
    public static function getAllInjuryName()
    {
        return $mInjuryNames = MInjuryName::all();
    }

}
