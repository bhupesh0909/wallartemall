<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Refer
 * @package App\Models
 * @version January 6, 2020, 4:56 pm UTC
 *
 * @property string refer_by
 * @property string refer_to
 * @property string status
 */
class Refer extends Model
{
    use SoftDeletes;

    public $table = 'refers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'refer_by',
        'refer_to',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'refer_by' => 'integer',
        'refer_to' => 'integer',
        'status' => 'enum'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'refer_by' => 'required',
        'refer_to' => 'required',
        'status' => 'required'
    ];
}