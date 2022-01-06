<?php

namespace App\Models;

//use Eloquent as Model;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * @package App\Models
 * @version November 23, 2019, 4:42 am UTC
 *
 * @property string transaction_id
 * @property string amount
 * @property string date_time
 * @property string status
 */
class Transaction extends Model
{
    use SoftDeletes;

    public $table = 'transactions';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'date_time',
        'status',
		'trans_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'transaction_id' => 'string',
        'amount' => 'string',
        'status' => 'enum',
		'trans_type' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'transaction_id' => 'required',
        'amount' => 'required',
        'status' => 'required',
        'trans_type' => 'trans_type'
    ];

    public function MakeTransaction($request)
    {
        return Transaction::create([
            'user_id' => $request['user_id'],
            // 'transaction_id' => rand(9, 999999), //it should be change.
            'transaction_id' => time(),
            'amount' => $request['amount'],
            'trans_type' => $request['trans_type'],
//            'status' => $request['status']
        ]);
    }

    public function GetTransactionList($user_id)
    {
        return Transaction::select('id', 'user_id', 'amount', 'date_time', 'status', 'trans_type')->where('user_id', $user_id)->get();
    }

    public function GetNetBalance($user_id){
        return User::select('total_amount')->where('id',$user_id)->first();
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}