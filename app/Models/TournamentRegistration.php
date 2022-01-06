<?php

namespace App\Models;

//use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentRegistration extends Model
{
    use SoftDeletes;

    public $table = 'tournament_registrations';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        't_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        't_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        't_id' => 'required',
    ];

    public function UserTournamentRegistration($request)
    {
        $UserTournament = TournamentRegistration::create([
            'user_id' => $request['user_id'],
            't_id' => $request['tournament_id'],
        ]);
        return $UserTournament;
    }
}