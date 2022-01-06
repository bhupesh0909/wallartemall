<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Promotion
 * @package App\Models
 * @version December 9, 2019, 6:41 pm UTC
 *
 * @property string promo_code
 * @property string description
 */
class Promotion extends Model
{
    use SoftDeletes;

    public $table = 'promotions';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'promo_code',
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
        'promo_code' => 'string',
        'description' => 'string',
        'is_active' => 'enum'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'promo_code' => 'required',
        'description' => 'required'
    ];


}
