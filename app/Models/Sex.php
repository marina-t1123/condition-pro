<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sex extends Model
{
    use HasFactory;

    protected $fillable = ['sex_name'];

    // リレーション
    public function athletes(): HasMany
    {
        return $this->hasMany(Athlete::class, 'sex_id')->chaperone();
    }
}
