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

    /**
     * 条件に合う傷病名を取得
     */
    public static function retrieveMInjuryNames($searchName)
    {
        // 傷病名のクエリビルダを設定
        $query = MInjuryName::query();

        if(!empty($searchName)){
            $query->where('injury_name', 'LIKE', '%'.$searchName.'%');
        }

        $searchInjuryNames = $query;

        return $searchInjuryNames;
    }

}
