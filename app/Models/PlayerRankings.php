<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PlayerRankings extends Model
{
    use SoftDeletes;
    protected $table = "player_ranking";
    protected $fillable = [
        'level',
        'matches',
    ];
}
