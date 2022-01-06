<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SendInvitation
 * @package App\Models
 * @version December 30, 2019, 6:01 pm UTC
 *
 * @property string send_to
 * @property strng send_by
 */
class SendInvitation extends Model
{
    use SoftDeletes;

    public $table = 'send_invitations';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'send_to',
        'send_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'send_to' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'send_to' => 'required',
        'send_by' => 'required'
    ];

    
}
