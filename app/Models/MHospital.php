<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MHospital extends Model
{
    protected $fillable = ['hospital_name'];

    // relations

    /**
     * 指定されたIDを持つ病院マスタを取得する
     *
     * @param int $id
     */
    public static function getHospitalSpecifiedId($id)
    {
        $getHospital = MHospital::findOrFail($id);

        return $getHospital;
    }


    /**
     * 検索条件に合う病院マスタを取得する
     *
     */
    public static function retrieveHospitals($searchKeyword)
    {
        // 検索キーワードの値をinputで取得
        $keyword = $searchKeyword->input('hospital_name');

        // クエリビルダーを作成
        $query = MHospital::query();

        // もし、検索キーワードがあった場合 hospital_nameカラムで曖昧検索条件を追加する
        if(!empty($searchKeyword)) {
            $query->where('hospital_name', 'LIKE', '%'.$keyword.'%');
        }

        return $query->get();
    }

}
