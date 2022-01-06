<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameWinner extends Model
{
    use SoftDeletes;

    public $table = 'game_winner';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'game_type',
        'game_id',
        'win_amount',
        'status',
        'tournament_id',
        'room_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'tournament_id' => 'integer',
        'room_id' => 'integer',
        'game_type' => 'enum',
        'game_id' => 'integer',
        'win_amount' => 'integer',
        'status' => 'enum'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'game_type' => 'required',
        'game_id' => 'required',
        'win_amount' => 'required',
    ];
}
