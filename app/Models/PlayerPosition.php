<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlayerPosition extends Model
{
    use HasFactory;

    protected $fillable = ['athlete_id', 'm_evente_position_id'];


}
