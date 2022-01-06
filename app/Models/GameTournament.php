<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GameTournament
 * @package App\Models
 * @version November 22, 2019, 5:49 am UTC
 *
 * @property string t_type
 * @property string t_id
 * @property string t_format
 * @property string start_date
 * @property string entry
 * @property string starting_stack
 * @property string prize
 * @property string level
 * @property string no_of_prizes
 * @property string r_user
 * @property string cash_prize
 */
class GameTournament extends Model
{
    use SoftDeletes;

    public $table = 'game_tournaments';


    protected $dates = ['deleted_at'];


    public $fillable = [
        't_type',
        't_id',
        't_format',
        'start_date',
        'entry',
        'starting_stack',
        'prize',
        'level',
        'no_of_prizes',
        'r_user',
        'cash_prize',
        'banner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        't_type' => 'integer',
        't_id' => 'string',
        't_format' => 'string',
        'start_date' => 'datetime',
        'entry' => 'integer',
        'starting_stack' => 'integer',
        'prize' => 'integer',
        'level' => 'string',
        'no_of_prizes' => 'integer',
        'r_user' => 'string',
        'cash_prize' => 'string',
        'banner' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
		't_type' => 'required',
		't_format' => 'required',
		'start_date' => 'required',
		'entry' => 'required|numeric',
		'starting_stack' => 'required',
		'prize' => 'required|numeric',
		//        'no_of_prizes' => 'required',
    ];
	
	public static $message = [
        't_format.required' => 'Tournament name is required',
        'starting_stack.required' => 'Total Spot is required',
    ];
}
