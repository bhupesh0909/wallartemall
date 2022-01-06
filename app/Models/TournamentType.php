<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TournamentType
 * @package App\Models
 * @version December 1, 2019, 4:29 am UTC
 *
 * @property string tournament_type
 * @property string status
 */
class TournamentType extends Model
{
    use SoftDeletes;

    public $table = 'tournament_types';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tournament_type',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tournament_type' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tournament_type' => 'required',
        'status' => 'required'
    ];

    
}
