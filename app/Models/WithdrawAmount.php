<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Withdraw_amount
 * @package App\Models
 * @version December 11, 2019, 4:40 pm UTC
 *
 * @property string user_id
 * @property string amount
 * @property string is_released
 */
class WithdrawAmount extends Model
{
    use SoftDeletes;

    public $table = 'withdraw_amounts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'amount',
        'deductions',
        'net_amount',
        'is_released'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'integer',
        'is_released' => 'enum'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'amount' => 'required',
        'is_released' => 'required'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}