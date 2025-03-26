<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MEventPosition extends Model
{
    use HasFactory;

    protected $fillable = ['m_event_id', 'event_position_name'];

    /**
     * ポジション・階級に紐づく種目
     */
    public function mEvent(): BelongsTo
    {
        return $this->belongsTo(MEvent::class);
    }

    /**
     * ポジション・階級に紐づく選手
     */
    public function athletes():BelongsToMany
    {
        return $this->belongsToMany(Athlete::class, 'player_position', 'athlete_id', 'm_event_position_id')->withTimestamps();
    }



}
