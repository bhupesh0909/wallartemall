<?php

namespace App\Repositories;

use App\Models\Refer;
use App\Repositories\BaseRepository;
use App\User;
use App\Models\Chip;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Rewards;
use DB;
/**
 * Class ReferRepository
 * @package App\Repositories
 * @version January 6, 2020, 4:56 pm UTC
 */
class ReferRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'refer_by',
        'refer_to',
        'status'
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
        return Refer::class;
    }

    public function Referfriend($request)
    {
        return Refer::create([
            'refer_by' => $request['refer_by'],
            'refer_to' => $request['refer_to'],
        ]);
    }

    public function ValidReferCode($reffer_code)
    {
        return User::where('refer_code', $reffer_code)->exists();
    }

    public function getAllRewards(){
        $rewards = collect(DB::select(DB::raw("SELECT LOWER(REPLACE(reward, ' ', '_')) as reward, chips FROM rewards WHERE deleted_at IS NULL")));
        $rewards = $rewards->pluck('chips','reward');
        return $rewards;
    }

    public function addVerificationReward($user_id){
        $user = User::where('id', $user_id)->first();
        $rewards = $this->getAllRewards();
        // dd($user->toArray(), $rewards->toArray());
        if(!empty($user->email_verified_at) && !empty($user->mobile_verified_at)){
            $user->total_amount += (int) $rewards['communication_details_verification_reward']??0;
            $user->save();
            $subject = 'Contact details verified';
            $message = "{$rewards['communication_details_verification_reward']} chips credited to your account for verifying contact details.";
            $type = 'verification';
            $icon = asset('assets/img/chips-red.png');
            $this->createNotification($user_id, $user_id, $type, $subject, $message, $icon);
            return true;
        }
        return false;
    }

    public function createNotification($sendTo, $sendBy, $type, $title, $message, $icon){
        Notification::create([
            'notification_type' => $type,
            'send_to' => $sendTo,
            'send_by' => $sendBy,
            'notification_title' => $title,
            'notification_desc' => $message,
            'icon' => $icon,
        ]);
    }

    public function GetReward($request)
    {
        $rewards = $this->getAllRewards();
        $amount = 0;
        $valid_refer_code = User::where('refer_code', $request['refer_code'])->exists();
        if ($valid_refer_code) {

            $user_id = User::where('refer_code', $request['refer_code'])->first();

            //            'status' => $request['status']


            $ifAlredyRewarded = Refer::where('refer_to', $request['user_id'])->where('refer_by', $user_id->id)->where('status', '1')->first();
            $referByUserName = null;
            $referToUserName = null;
            if (!$ifAlredyRewarded) {

                $referByUser = $user_id->id;
                $refererByUserChips = Chip::where('user_id', $referByUser)->first();
                if (!$refererByUserChips) {
                    Chip::create([
                        'user_id' => $referByUser,
                        'chips_amount' => $rewards['referrer_reward'],
                        'chips_type' => 'RR',
                    ]);
                    $amount = $rewards['referrer_reward'];
                } else {
                    $referByAmount = $refererByUserChips->chips_amount + $rewards['referrer_reward'];
                    Chip::where('user_id', $referByUser)->update(['chips_amount' => $referByAmount]);
                    $amount = $rewards['referrer_reward'];
                    $user = User::where('id', $referByUser)->first();
                    $user->total_amount += $amount;
                    $user->save();
                    $referByUserName = $user->username;
                }

                $referToUser = $request['user_id'];
                $refererToUserChips = Chip::where('user_id', $referToUser)->first();
                if (!$refererToUserChips) {
                    Chip::create([
                        'user_id' => $referToUser,
                        'chips_amount' => $rewards['referee_reward'],
                        'chips_type' => 'RR',
                    ]);
                    $amount = $rewards['referee_reward'];
                    $user = User::where('id', $referToUser)->first();
                    $user->total_amount += $amount;
                    $user->referred_by = $referByUser;
                    $user->save();
                    $referToUserName = $user->username;
                } else {
                    $referToAmount = $refererToUserChips->chips_amount + $rewards['referee_reward'];
                    Chip::where('user_id', $referToUser)->update(['chips_amount' => $referToAmount]);
                    $amount = $rewards['referee_reward'];
                }

                Refer::where('refer_to', $request['user_id'])->where('refer_by', $user_id->id)->update(['status' => '1']);

                $newTrans = Transaction::create([
                    'user_id' => $user_id->id,
                    // 'transaction_id' => rand(9, 999999), //it should be change.
                    'transaction_id' => time(), //it should be change.
                    'amount' => $rewards['referee_reward'],
                    'trans_type' => 'referral',
                    'date_time' => date('Y-m-d H:i:s'),
                ]);
                // add notification for successful refer to referer
                Notification::create([
                    'notification_type' => 'invitation',
                    'send_to' => $referByUser,
                    'send_by' => $referByUser,
                    'notification_title' => 'Refer Bonus',
                    'notification_desc' => $rewards['referrer_reward'] . ' chips updated to your account for referring '.$referToUserName,
                    'icon' => asset('assets/img/chips-red.png'),
                ]);
                // add notification for successful refer to refree
                Notification::create([
                    'notification_type' => 'invitation',
                    'send_to' => $referToUser,
                    'send_by' => $referToUser,
                    'notification_title' => 'Refer Bonus',
                    'notification_desc' => $rewards['referee_reward'] . ' chips updated to your account for using '.$referByUserName. '\'s refer code',
                    'icon' => asset('assets/img/chips-red.png'),
                ]);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createFirstTimeRegistrationReward($params)
    {
        Chip::create($params);
    }
}
