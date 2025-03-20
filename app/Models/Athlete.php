<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'sex_id', 'name', 'birthday', 'memo'];

    /**
     * 　選手の性別
     */
    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }

    /**
     * 選手のチーム
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * 選手のポジション・階級
     */
    public function mEventPositions():BelongsToMany
    {
        return $this->belongsToMany(MEventPosition::class, 'player_position')->withTimestamps();
    }

    /**
     * 特定の条件に一致する選手情報を関連情報と一緒に取得
     */
    public static function featchSearchAthlete($search_name, $search_event_id, $search_position_id)
    {
        // 選手のクエリビルダを設定（この時、リレーション関係にあるteamとsexの情報も一緒に取得する）
        $query = Athlete::query()->with(['team', 'sex', 'mEventPositions.mEvent']);

        // 選手の名前が検索フォームから検索された場合
        if(!empty($search_name)) {
            $query->where('name', 'LIKE', '%{$search_name}%');
        }

        // 種目名が検索フォームから検索された場合
        if(!empty($search_event_id)) {
            $query->whereHas('Team', function($query) use ($search_event_id) {
                $query->where('m_event_id', $search_event_id);
            });
        }

        // 種目名、ポジション・階級のそれぞれのIDが送信された場合
        if(!empty($search_event_id) && !empty($search_position_id)) {
            // すでに取得済みの選手情報に紐づくポジションを指定条件で取得
            $query->load(['mEventPositions' => function($query) use($search_event_id, $search_position_id) {
                // 指定されたポジションIDのみ取得する
                $query->where('m_event_positions.id', $search_position_id)
                    // かつ、そのポジションが指定された種目に属していることを確認
                    ->whereHas('mEvent', function($sq) use ($search_event_id) {

                    });
            }]);

        }
    }
}
