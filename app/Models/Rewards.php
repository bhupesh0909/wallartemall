<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Rewards extends Model
{
    use SoftDeletes;
    protected $table = "rewards";
    protected $fillable = ['reward', 'chips'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
}
