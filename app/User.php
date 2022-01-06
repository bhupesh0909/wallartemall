<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'dob', 'gender', 'state', 'forgot_token',
        'fcm_token', 'profile_pic', 'sound', 'vibrate', 'chat', 'profile', 'is_block',
        'email_verified_at', 'total_amount', 'redeem', 'pending_bonus', 'inplay_cash',
        'mobile_verified_at', 'id_proof', 'kyc_verification', 'active_user', 'mobile_number', 'refer_code', 'user_type', 'device_token', 'referred_by'
    ];


    // Please ADD this two methods at the end of the class
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_amount' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function ValidUser($user_id)
    {
        $user = User::where('id', $user_id)->exists();
        if ($user) {
            return $user;
        } else {
            return $user;
        }
    }

    public function ValidUserEmail($user_email)
    {
        $user = User::where('email', $user_email)->exists();
        if ($user) {
            return $user->id;
        } else {
            return $user;
        }
    }

    public function AccountStatement($user_id, $game_amount)
    {
        $user = User::where('id', $user_id)->first();
        if ($user->total_amount >= $game_amount) {
            return true;
        } else {
            return false;
        }
    }

    public function GetAccountInfo($user_id)
    {
        // $data = User::select('id', 'total_amount', 'total_played', 'winner', 'redeem', 'pending_bonus', 'inplay_cash', 'profile_pic')->where('id', $user_id);
        $data = collect(DB::select("CALL `Get_Account_Info`({$user_id})"));
        return $data->first();
    }

    public function PasswordVerify($old_password, $user_id)
    {
        return User::where('id', $user_id)
            ->where('password', hash('sha256', $old_password))->exists();
    }

    public function UpdatePassword($user_id, $new_password)
    {
        return User::where('id', $user_id)->update(['password' =>  hash('sha256', $new_password)]);
    }

    public function EmailVerification($user_id)
    {
        return User::whereNotNull('email_verified_at')->where('id', $user_id)->exists();
    }

    public function MobileVerification($user_id)
    {
        return User::whereNotNull('mobile_verified_at')->where('id', $user_id)->exists();
    }

    public function AddIdProofs($user_id, $id_proof, $data)
    {
        return User::where('id', $user_id)->update(['id_proof' => $id_proof, 'bank_account_no' => $data['bank_account_no'], 'bank_name' => $data['bank_name'], 'ifsc_code' => $data['ifsc_code'], 'payee_name' => $data['payee_name'], 'account_type' => $data['account_type'], 'pancard_no' => $data['pancard_no'], 'kyc_verification' => date('Y-m-d H:i:s'), 'is_kyc_verified' => 0]);
    }

    public function GetPlayers()
    {
        return User::where('role', 'user')->get();
    }

    public function UserLogout($user_id)
    {
        return User::where('id', $user_id)->update(['api_token' => '']);
    }


    public function DeleteUser($user_id)
    {
        return User::where('id', $user_id)->update(['is_deleted' => '1', 'deleted_at' => date('Y-m-d H:i:s'), 'api_token' => '']);
    }

    public function GetUserToken($user_id)
    {
        return User::select('fcm_token')->where('id', $user_id)->first();
    }

    public static function GetUserApiToken($user_id)
    {
        return User::select('api_token')->where('is_deleted', '0')->where('id', $user_id)->first();
    }

    public static function createApiToken($user_id, $token)
    {
        return User::where('id', $user_id)->update(['api_token' => $token]);
    }

    public function updateTotalAmount($user_id, $amount)
    {
        return User::where('id', $user_id)->update(['total_amount' => $amount]);
    }
}
