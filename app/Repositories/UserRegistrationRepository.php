<?php

namespace App\Repositories;

use App\Models\UserRegistration;
use App\Repositories\BaseRepository;
use App\User;

/**
 * Class UserRegistrationRepository
 * @package App\Repositories
 * @version November 21, 2019, 3:45 am UTC
 */
class UserRegistrationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'email',
        'dob',
        'gender',
        'state',
        'social_media'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserRegistration::class;
    }

    public function sendOTP($mobileNumber, $userId)
    {

        $randNumbr = rand(1000, 9999);
        $packageID = '12345678901';
        $message = '<#> Your OTP for Rummy Boos app is : ' . $randNumbr . ' ' . $packageID;
        $url = 'http://www.bulksmsapps.com/api/apismsv2.aspx?apikey=97d7ce77-bcf3-4901-b39a-f3cd38eece31&sender=SWTHGY&number=' . $mobileNumber . '&message=' . urlencode($message);

        if (!in_array(env('APP_ENV'), explode(',', 'EXCLUDE_OTP_ENV')) && file_get_contents($url)) {
            User::where('id', $userId)->update(['otp' => $randNumbr]);
            return true;
        } else {
            return false;
        }
    }


    /*public function sendOTP($mobileNumber, $userId){
        $username = "nikhil.thingalaya@gigsmedia.in";
        $hash = "bd87b4d7c830ef89544c589d0e202f6a849b38b7343dc5f43fc9c18784d47a08";
        $test = "0";
        $randNumbr = rand(1000,9999);
        $packageID = '12345678901';
        $sender = "DWLDEN"; 
        $numbers = "91".$mobileNumber;
        $message = '<#> Your OTP for Rummy Boos app is : ' . $randNumbr . ' ' . $packageID;
        $message = urlencode($message);
        $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result =  json_decode($result);
        if(isset($result->status) && $result->status == "success"){
            User::where('id', $userId)->update(['otp' => $randNumbr]);
            return true;
        }else{
            return false;
        }
    }*/
}
