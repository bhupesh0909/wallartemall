<?php

namespace App\Models;


//use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCard extends Model
{
    use SoftDeletes;

    public $table = 'user_cards';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'card_number',
        'card_type',
        'card_holder_name',
        'expire_date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'card_number' => 'integer',
        'card_type' => 'string',
        'card_holder_name' => 'string',
        'expire_date' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'card_number' => 'required',
        'card_type' => 'required',
        'card_holder_name' => 'required',
        'expire_date' => 'required',
    ];

    public function CardExists($request)
    {
        return UserCard::where('user_id', $request['user_id'])
            ->where('card_number', $request['card_number'])->exists();;
    }

    public function AddCard($request)
    {
        $card_add = UserCard::create([
            'user_id' => $request['user_id'],
            'card_number' => $request['card_number'],
            'expire_date' => $request['expire_date'],
            'card_holder_name' => $request['card_holder_name'],
            'card_type' => $request['card_type'],
        ]);
        return $card_add;
    }
}