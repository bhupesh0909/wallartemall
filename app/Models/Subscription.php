<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 * @package App\Models
 * @version December 1, 2019, 6:32 am UTC
 *
 * @property string subscription_title
 * @property string description
 * @property string amount
 */
class Subscription extends Model
{
    use SoftDeletes;

    public $table = 'subscriptions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'subscription_title',
        'description',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'subscription_title' => 'string',
        'description' => 'string',
        'amount' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subscription_title' => 'required',
        'amount' => 'required|numeric'
    ];
}
