<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MEvent extends Model
{
    use HasFactory;

    protected $fillable = ['event_name'];

    //　リレーション

    /**
     * 種目に紐づくポジション・階級マスタ
     */
    public function mEventPositions(): HasMany
    {
        return $this->hasMany(MEventPosition::class, 'm_event_id')->chaperone();
        // chaperoneを使用することで、MEventPosition（子テーブル）→MEvent(親テーブル)のリレーションも自動的に認識してくれる
    }

    /**
     * 種目に紐づくチーム
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'm_event_id')->chaperone();
    }

    /**
     * 全種目情報と紐づくポジション・階級マスタを取得
     */
    public static function getAllMEventAndPositions()
    {
        $query = MEvent::query();
        $all_m_events = $query->with('mEventPositions');

        return $all_m_events;
    }


}
