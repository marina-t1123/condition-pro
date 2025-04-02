<?php

namespace App\Models;

use Illnminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MBodyPart extends Model
{
    // use HasFactory;

    protected $fillable = ['body_part_name'];

    // relation

    /**
     * 部位に紐づく傷病情報マスタ
     */

    
}
