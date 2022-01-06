<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialRegistration extends Model
{
    use SoftDeletes;

    public $table = 'social_registrations';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'social_token',
        'social_user_id',
        'social_media'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'string',
        'social_token' => 'string',
        'social_user_id' => 'string',
        'social_media' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'social_user_id' => 'required',
        'social_token' => 'required',
        'social_media' => 'required'
    ];
}
