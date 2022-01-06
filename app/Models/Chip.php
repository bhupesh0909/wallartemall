<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Chip
 * @package App\Models
 * @version December 8, 2019, 6:47 am UTC
 *
 * @property string user_id
 * @property string chips_amount
 */
class Chip extends Model
{
    use SoftDeletes;

    public $table = 'chips';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'chips_amount',
        'chips_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'chips_amount' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'chips_amount' => 'required|numeric|digits_between:1,5'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}
