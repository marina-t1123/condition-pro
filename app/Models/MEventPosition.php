<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MEventPosition extends Model
{
    use HasFactory;

    protected $fillable = ['m_event_id', 'event_position_name'];

    // リレーション
    public function mEvent(): BelongsTo
    {
        return $this->belongsTo(MEvent::class);
    }
}
