<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GameType
 * @package App\Models
 * @version November 22, 2019, 4:14 am UTC
 *
 * @property string game_type
 * @property string game_icon
 * @property string is_active
 */
class GameType extends Model
{
    use SoftDeletes;

    public $table = 'game_types';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'game_type',
        'game_icon',
        'description',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game_type' => 'string',
        'game_icon' => 'string',
        'is_active' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'game_type' => 'required',
        'game_icon' => 'required',
        'is_active' => 'required'
    ];
}