<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlayGame
 * @package App\Models
 * @version November 27, 2019, 6:06 am UTC
 *
 * @property string game_type
 * @property strring game_id
 * @property string user_id
 * @property string total_players
 * @property string entry_fee
 * @property string game_status
 */
class PlayGame extends Model
{
    use SoftDeletes;

    public $table = 'play_games';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'game_type',
        'game_id',
        'tournament_id',
        'user_id',
        'total_players',
        'entry_fee',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game_type' => 'enum',
        'user_id' => 'integer',
        'total_players' => 'integer',
        'entry_fee' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'game_type' => 'required',
        'game_id' => 'required',
        'user_id' => 'required',
        'total_players' => 'required',
        'entry_fee' => 'required',
    ];


    public function StartGame($request)
    {
        return PlayGame::create([
            'game_type' => $request['game_type'],
            'game_id' => $request['game_id'],
            'tournament_id' => $request['tournament_id'],
            'user_id' => $request['user_id'],
            'total_players' => $request['total_players'],
            'entry_fee' => $request['entry_fee'],
        ]);
    }
}
