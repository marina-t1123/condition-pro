<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['m_event_id','team_name', 'memo'];

    // リレーション
    public function mEvent(): BelongsTo
    {
        return $this->belongsTo(MEvent::class);
    }

    /**
     * チームに紐づく選手
     */
    public function athletes(): HasMany
    {
        return $this->hasMany(Athlete::class, 'team_id')->chaperone();
    }

    /**
     * 選手一覧画面での検索
     */
    public static function featchSerachTeams($m_event_id, $keyword)
    {
        $query = Team::query();

        if (!empty($m_event_id)) {
            $query->where('m_event_id', $m_event_id);
        }

        if (!empty($keyword)) {
            $query->where("team_name", "LIKE", "%{$keyword}%");
        }

        $searchTeams = $query->with('mEvent');

        return $searchTeams;
    }

    /**
     * 登録済みの各チーム情報に紐づく種目・ポジションを取得する
     */
}
