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
    public function mEventPositions(): HasMany
    {
        return $this->hasMany(MEventPosition::class, 'm_event_id')->chaperone();
        // chaperoneを使用することで、MEventPosition（子テーブル）→MEvent(親テーブル)のリレーションも自動的に認識してくれる
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'm_event_id')->chaperone();
    }
}
