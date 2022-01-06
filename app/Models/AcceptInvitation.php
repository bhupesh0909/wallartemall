<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcceptInvitation extends Model
{
    use SoftDeletes;

    public $table = 'accept_invitations';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'send_by',
        'accept_by',
        'get_commission',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'send_by' => 'integer',
        'accept_by' => 'integer',
        'get_commission' => 'enum',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'send_by' => 'required',
        'accept_by' => 'required|numeric'
    ];
}
