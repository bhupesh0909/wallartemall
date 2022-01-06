<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserRegistration
 * @package App\Models
 * @version November 21, 2019, 3:45 am UTC
 *
 * @property string username
 * @property string email
 * @property string dob
 * @property string gender
 * @property string state
 * @property string social_media
 */
class UserRegistration extends Model
{
    use SoftDeletes;

    public $table = 'users';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'username',
        'email',
        'dob',
        'gender',
        'state',
        // 'social_media'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'email' => 'string',
        'dob' => 'date',
        'gender' => 'string',
        'state' => 'string',
        // 'social_media' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'required',
        'email' => 'required',
        'dob' => 'required',
        'gender' => 'required',
        'state' => 'required',
        // 'social_media' => 'required'
    ];

    
}
