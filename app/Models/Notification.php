<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
//    use SoftDeletes;
    public $timestamps = false;
    public $table = 'notification';

//    protected $dates = ['deleted_at'];
    public $fillable = [
        'notification_type',
        'send_by',
        'send_to',
        'notification_title',
        'notification_desc',
        'icon',
        'is_read',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'notification_type' => 'string',
        'send_to' => 'integer',
        'send_by' => 'integer',
        'is_read' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}
