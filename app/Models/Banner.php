<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 * @package App\Models
 * @version December 7, 2019, 1:57 pm UTC
 *
 * @property string banner_image
 * @property string status
 */
class Banner extends Model
{
    use SoftDeletes;

    public $table = 'banners';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'banner_image',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'banner_image' => 'string',
        'is_active' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'banner_image' => 'required',
        'is_active' => 'required'
    ];
}