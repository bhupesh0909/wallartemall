<?php

namespace App\Repositories;

use App\Models\AcceptInvitation;
use App\Models\Notification;
use App\Models\SendInvitation;
use App\Repositories\BaseRepository;
use App\User;

/**
 * Class SendInvitationRepository
 * @package App\Repositories
 * @version December 30, 2019, 6:01 pm UTC
 */
class SendInvitationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'send_to',
        'send_by'
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
        return SendInvitation::class;
    }

    public function SendInvitation($send_by, $send_to)
    {
    	$flag  = "";    	
    	$prefix = $unsent = '';
        foreach (explode(',', $send_to) as $o) {
			
		    $chk_valid_user = User::where('id',$o)->first();
			if ($chk_valid_user) {
						
						$fcm_token = User::select('fcm_token')->where('id', $o)->first();
						
						$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
						$notification = [
							'title' => 'Play Rummy',
							'body' => 'You have invitation.',
							'sound' => true,
						];

						$extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

						$fcmNotification = [
							//'registration_ids' => $tokenList, //multple token array
							'to' => $fcm_token, //single token
							'notification' => $notification,
							'data' => $extraNotificationData
						];

						$headers = [
							'Authorization:AIzaSyAmdmbE-jKloCzgk9qiW7D9U3kyCXIqrdo',
							'Content-Type: application/json'
						];

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $fcmUrl);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
						$result = curl_exec($ch);
						curl_close($ch);

						Notification::create([
							'notification_type' => 'invitation',
							'send_to' => $o,
							'send_by' => $send_by,
						]);

						SendInvitation::create(['send_by' => $send_by, 'send_to' => $o]);
						
					    $flag = 0;		
					}	
					else
					{
						
						$unsent .= $prefix . $o;
    					$prefix = ', ';
						  

					}	
				}
				
				return array('sent_flag'=>$flag,'unsent_flag'=>$unsent);
				
    }

    public function AcceptInvitation($invited_by, $user_id)
    {
        AcceptInvitation::create(['send_by' => $invited_by, 'accept_by' => $user_id]);
    }
}
