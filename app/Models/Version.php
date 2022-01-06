<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Version
 * @package App\Models
 * @version December 8, 2019, 6:47 am UTC
 *
 * @property string version
 */
class Version extends Model
{
    use SoftDeletes;

    public $table = 'version';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'version'
    ];
}
