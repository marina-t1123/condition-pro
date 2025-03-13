<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['m_event_id','team_name', 'memo'];

    // リレーション
    public function mEvent(): BelongsTo
    {
        return $this->belongsTo(MEvent::class);
    }

    // メソッド
    public static function featchSerachItems($m_event_id, $keyword)
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
}
