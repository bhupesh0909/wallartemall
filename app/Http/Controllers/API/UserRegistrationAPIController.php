<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\SocialRegistrationController;
use App\Http\Requests\API\CreateUserRegistrationAPIRequest;
use App\Http\Requests\API\UpdateUserRegistrationAPIRequest;
use App\Models\Notification;
use App\Models\SocialRegistration;
use App\Models\UserRegistration;
use App\Repositories\UserRegistrationRepository;
use App\User;
use App\Models\Version;
use App\Repositories\ReferRepository;
use App\Models\Chip;
use App\Repositories\ChipRepository;
use Aws\Sns\SnsClient;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\PlayerRankings;
use Response;
use Validator;
use Str;
use JWTAuth;

/**
 * Class UserRegistrationController
 * @package App\Http\Controllers\API
 */
class UserRegistrationAPIController extends AppBaseController
{
    /** @var  UserRegistrationRepository */
    private $userRegistrationRepository;
    private $referRepository;
    private $user;
    private $chipRepository;

    public function __construct(UserRegistrationRepository $userRegistrationRepo, User $user, ReferRepository $referRepo, ChipRepository $chipRepo)
    {
        $this->userRegistrationRepository = $userRegistrationRepo;
        $this->user = $user;
        $this->referRepository = $referRepo;
        $this->chipRepository = $chipRepo;
    }

    /**
     * Display a listing of the UserRegistration.
     * GET|HEAD /userRegistrations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userRegistrations = $this->userRegistrationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userRegistrations->toArray(), 'User Registrations retrieved successfully');
    }

    /**
     * Store a newly created UserRegistration in storage.
     * POST /userRegistrations
     *
     * @param CreateUserRegistrationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRegistrationAPIRequest $request)
    {
        $input = $request->all();

        $userRegistration = $this->userRegistrationRepository->create($input);

        return $this->sendResponse($userRegistration->toArray(), 'User Registration saved successfully');
    }

    /**
     * Display the specified UserRegistration.
     * GET|HEAD /userRegistrations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserRegistration $userRegistration */
        $userRegistration = $this->userRegistrationRepository->find($id);

        if (empty($userRegistration)) {
            return $this->sendError('User Registration not found');
        }

        return $this->sendResponse($userRegistration->toArray(), 'User Registration retrieved successfully');
    }

    /**
     * Update the specified UserRegistration in storage.
     * PUT/PATCH /userRegistrations/{id}
     *
     * @param int $id
     * @param UpdateUserRegistrationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRegistrationAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserRegistration $userRegistration */
        $userRegistration = $this->userRegistrationRepository->find($id);

        if (empty($userRegistration)) {
            return $this->sendError('User Registration not found');
        }

        $userRegistration = $this->userRegistrationRepository->update($input, $id);

        return $this->sendResponse($userRegistration->toArray(), 'UserRegistration updated successfully');
    }

    /**
     * Remove the specified UserRegistration from storage.
     * DELETE /userRegistrations/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var UserRegistration $userRegistration */
        $userRegistration = $this->userRegistrationRepository->find($id);

        if (empty($userRegistration)) {
            return $this->sendError('User Registration not found');
        }

        $userRegistration->delete();

        return $this->sendSuccess('User Registration deleted successfully');
    }

    public function GetApiToken(Request $request)
    {
        return User::GetUserApiToken($request->user_id);
    }

    //CreateUserRegistrationAPIRequest
    public function UserRegistration(Request $request)
    {
        /*$sdk = new SnsClient([
            'region' => 'eu-west-1',
            'version' => 'latest',
            'credentials' => ['key' => 'AKIA6MKPDI6LTEGSRO7T', 'secret' => '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']
        ]);

        $result = $sdk->publish([
            'Message' => 'This is a test message.',
            'PhoneNumber' => '+917020265006',
            'MessageAttributes' => ['AWS.SNS.SMS.SenderID' => [
                'DataType' => 'String',
                'StringValue' => 'WebNiraj'
            ]
            ]]);

        dd($result);*/

        try {
            $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 6)), 0, 6);
            if (isset($request->social_media) && isset($request->social_token) && isset($request->social_user_id)) {
                if (SocialRegistration::where('social_token', $request->social_token)->exists()) {
                    return response::json(['status' => 0, 'registration' => null, 'message' => ['This user already exists.']]);
                } else if (trim($request->social_user_id) != "") {


                    $validator = Validator::make($request->all(), [
                        'username' => 'required|alpha_num|between:4,15',
                        'email' => 'required|email|max:40',
                        // 'dob' => 'date|before: -18 years',
                        'user_type' => 'required|integer|between:0,1',
                        'gender' => 'regex:/^[Male\Female]*$/',
                        'mobile_number' => 'numeric|digits:10',
                        'state' => 'nullable|string|max:30',
                        'fcm' => 'string|max:100',
                        // 'refer_code' => ['nullable', "exists:users,refer_code"],
                    ], [
                        // 'dob.before' => 'You must be 18 years old or above',
                        'refer_code.exists' => 'Refer code is invalid',
                    ]);


                    if (!$validator->passes()) {
                        return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
                    }

                    $user_registration = User::create([
                        'username' => $request->username,
                        'email' => $request->email,
                        //                    'password' => $password,
                        'role' => "user",
                        // 'dob' => $request->dob,
                        'gender' => $request->gender,
                        'state' => $request->state,
                        'fcm_token' => $request->fcm_token,
                        'mobile_number' => $request->mobile_number,
                        'refer_code' => $s,
                        'user_type' => $request->user_type,
                    ]);
                    SocialRegistration::create([
                        'user_id' => $user_registration->id,
                        'social_token' => $request->social_token,
                        'social_media' => $request->social_media,
                        'social_user_id' => $request->social_user_id,
                    ]);
                    $result = Crypt::encrypt($request->email);
                    //                    $result = hash("sha256", $request->email);
                    $to_email = $request->email;
                    if ($to_email != null) {
                        $data = [
                            'email' => $to_email,
                            'token' => $result
                        ];
                        Mail::send('emails.user_confirmation', $data, function ($message) use ($to_email) {
                            $message->to($to_email)
                                ->subject('Verify your email address');
                            $message->from('noreply@rummyboss.com', 'Email Confirmation');
                        });
                    }
                    return response::json(['status' => 1, 'registration' => $user_registration, 'message' => ['User Successfully Registered.']]);
                }
            } else {

                $validator = Validator::make($request->all(), [
                    'username' => 'required|alpha_num|between:4,15',
                    'email' => 'required|email|max:40',
                    // 'dob' => 'date|before: -18 years',
                    'user_type' => 'required|integer|between:0,1',
                    'gender' => 'regex:/^[Male\Female]*$/',
                    'mobile_number' => 'numeric|digits:10',
                    'state' => 'nullable|string|max:30',
                    // 'refer_code' => ['nullable', "exists:users,refer_code"],
                ], [
                    // 'dob.before' => 'You must be 18 years old or above',
                    'refer_code.exists' => 'Refer code is invalid',
                ]);

                if (!$validator->passes()) {
                    return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
                }

                $flag =  false;
                $message = "";
                if (strlen($request->username) < 6) {
                    $flag =  true;
                    $message = "Username should be 6 characters long.";
                } else if (preg_match("/^[a-zA-Z0-9]+$/", $request->username) == false) {
                    $flag =  true;
                    $message = "No special characters allowed in username.";
                } else if (User::where('username', $request->username)->exists()) {
                    $flag =  true;
                    $message = "This username is already exists.";
                } else if (strlen($request->password) < 6 || strlen($request->password) > 25) {
                    $flag =  true;
                    $message = "Password should be 6 to 25 characters long.";
                } else if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $request->email) == false) {
                    $flag =  true;
                    $message = "Please enter valid email address.";
                } else if (User::where('email', $request->email)->exists()) {
                    $flag =  true;
                    $message = "This email is already exists.";
                } else if (strlen($request->mobile_number) < 10 || strlen($request->mobile_number) > 10) {
                    $flag =  true;
                    $message = "Please enter 10 digits mobile number.";
                } else if (is_numeric($request->mobile_number) == false) {
                    $flag =  true;
                    $message = "Please enter digits only.";
                } else if (preg_match("/^[6-9]\d{9}$/", $request->mobile_number) == false) {
                    $flag =  true;
                    $message = "Invalid mobile number. It should start with 6, 7, 8, 9.";
                } else if (User::where('mobile_number', $request->mobile_number)->exists()) {
                    $flag =  true;
                    $message = "This mobile number is already exists.";
                } else {
                    $rewards = $this->referRepository->getAllRewards();
                    $referred_by = null;
                    if ($request->refer_code) {
                        $referred_by = User::select('id')->where('refer_code', $request->refer_code)->first();
                        $referred_by = ($referred_by) ? $referred_by->id : null;
                    }
                    # remove previous device token associated with any user and update this with current user
                    $userByDeviceToken = User::where('device_token', $request->device_token)->first();
                    if (isset($userByDeviceToken)) {
                        $userByDeviceToken->device_token = null;
                        $userByDeviceToken->save();
                    }
                    $password = hash('sha256', $request->password);
                    $user_registration = User::create([
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => $password,
                        'role' => "user",
                        // 'dob' => $request->dob,
                        'gender' => $request->gender,
                        'state' => $request->state,
                        'fcm_token' => $request->fcm_token,
                        'mobile_number' => $request->mobile_number,
                        'refer_code' => $s,
                        'user_type' => $request->user_type,
                        // 'total_amount' => config('custom.registration_reward'),
                        'total_amount' => $rewards['registration_reward'] ?? 0,
                        'device_token' => $request->device_token,
                        'referred_by' => $referred_by,
                    ]);
                    // $user_registration->api_token = hash('sha256', Str::random(254));
                    $user_registration->api_token = "Bearer " . JWTAuth::fromUser($user_registration);
                    // User::createApiToken($user_registration->id, $user_registration->api_token);
                    // refer friend and get reward
                    if (isset($request->refer_code) && $request->refer_code != "") {
                        $valid_refer_code = User::where('refer_code', $request['refer_code'])->exists();
                        if ($valid_refer_code) {
                            $referCodeUser = User::where('refer_code', $request['refer_code'])->first();
                            $referDataTosend['refer_by'] = $referCodeUser->id;
                            $referDataTosend['refer_to'] = $user_registration->id;
                            $refer = $this->referRepository->Referfriend($referDataTosend);
                            $rewardDataTosend['refer_code'] = $request['refer_code'];
                            $rewardDataTosend['user_id'] = $user_registration->id;
                            $reward = $this->referRepository->GetReward($rewardDataTosend);
                        }
                    } else {
                        $params = [
                            'user_id' => $user_registration->id,
                            // 'chips_amount' => config('custom.registration_reward'),
                            'chips_amount' => $rewards['registration_reward'] ?? 0,
                            'chips_type' => 'WR',
                        ];
                        // dd($rewards, $params);
                        $this->referRepository->createFirstTimeRegistrationReward($params);
                    }
                    // send mobile no verification otp
                    // $this->userRegistrationRepository->sendOTP($request->mobile_number, $user_registration->id);

                    $result = Crypt::encrypt($request->email);
                    $to_email = $request->email;
                    $data = [
                        'email' => $to_email,
                        'token' => $result
                    ];
                    Mail::send('emails.user_confirmation', $data, function ($message) use ($to_email) {
                        $message->to($to_email)
                            ->subject('Verify your email address');
                        $message->from('ppanchal912@gmail.com', 'Email Confirmation');
                    });
                    // add welcome bonus notification
                    if (isset($rewards['registration_reward'])) {
                        Notification::create([
                            'notification_type' => 'reward',
                            'send_to' => $user_registration->id,
                            'send_by' => $user_registration->id,
                            'notification_title' => 'Welcome Bonus',
                            'notification_desc' => $rewards['registration_reward'] . ' chips credited to your RummyBoss account',
                            'icon' => asset('public/assets/img/chips-red.png'),
                        ]);
                    }
                }
                if ($flag) {
                    return response::json(['status' => 0, 'registration' => null, 'message' => [$message]]);
                } else {
                    return response::json(['status' => 1, 'registration' => $user_registration, 'token' => $user_registration->api_token, 'message' => ['User Successfully Registered.']]);
                }
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'registration' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function sendVerificationMail($to_email, $data)
    {
        Mail::send('emails.user_confirmation', $data, function ($message) use ($to_email) {
            $message->to($to_email)
                ->subject('Verify your email address');
            $message->from('ppanchal912@gmail.com', 'Email Confirmation');
        });
    }

    public function EditProfile(Request $request)
    {
        // dd($request);
        try {
            $id = $request->user_id;
            $validator = Validator::make($request->all(), [

                'email' => 'email|unique:users,email,' . $id,
                'dob' => 'date|before: -18 years|nullable',
                'gender' => 'regex:/^[Male\Female]*$/',
                'mobile_number' => 'numeric|digits:10',
                // 'profile_pic' => 'image|mimes:jpeg,png,jpg,gif|max:1024|nullable',
            ], [

                'email.unique' => 'Email already registered.',
                'profile_pic.mimes' => 'Profile picture must be in jpeg/jpg/png format.',
                'profile_pic.max' => 'Please upload image of size 1mb',
                'dob.after' => 'You must be 18 years old or above',
            ]);
            if(isset($request->dob)){
                $dateValidator = Validator::make(['dob'=>$request->dob], [
                    'dob' => 'date|before: -18 years',
                ], [
                    'dob.after' => 'You must be 18 years old or above',
                ]);
                if (!$validator->passes()) {
                    return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
                }
            }
            if (!$validator->passes()) {
                return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
            }


            $userdata = User::where('id', $request->user_id)->first();
            if (!empty($request->dob)) {
                User::where('id', $request->user_id)->update(['dob' => $request->dob]);
            }
            if (!empty($request->email)) {
                User::where('id', $request->user_id)->update(['email' => $request->email]);
            }
            if (!empty($request->gender)) {
                User::where('id', $request->user_id)->update(['gender' => $request->gender]);
            }
            // if ($request->hasfile('profile_pic')) {
            //     if ($userdata->profile_pic != "") {
            //         $oldPicture = trim(basename($userdata->profile_pic));
            //         unlink(public_path("/profile_image/$oldPicture"));
            //     }
            //     $image = $request->file('profile_pic');
            //     $hash = hash_file('sha256', $image, false);
            //     $name = $hash . '.' . $image->getClientOriginalExtension();
            //     $destinationPath = public_path('/profile_image');
            //     $file_moved = $image->move($destinationPath, $name);

            //     $image_path = $name;
            //     User::where('id', $request->user_id)->update(['profile_pic' => $image_path]);
            // }
            if(!empty($request->profile_pic)){
                $uniqueId = uniqid();
                $fileName = "{$userdata->username}-{$uniqueId}.jpg";
                $old_profile_pic = $userdata->profile_pic;
                //save profile image
                file_put_contents(public_path("profile_image/{$fileName}"), base64_decode($request->profile_pic));
                User::where('id', $request->user_id)->update(['profile_pic' => $fileName]);
				if(file_exists(public_path("profile_image/{$old_profile_pic}"))){
					//delete old profile image
					unlink(public_path("profile_image/{$old_profile_pic}"));
				}
            }

            if (!empty($request->mobile_number)) {
                $mobileNumberExists = User::where('mobile_number', $request->mobile_number)->exists();
                if ($mobileNumberExists == true && $request->mobile_number != $userdata->mobile_number) {
                    return response::json(['status' => 0, 'edit_profile' => null, 'message' => ["This mobile number is already registered."]]);
                } else {
                    User::where('id', $request->user_id)->update(['mobile_number' => $request->mobile_number]);
                }
            }
            return response::json(['status' => 1, 'message' => ['User data updated Successfully.']]);
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'message' => [$e->getMessage()]]);
        }
    }


    public function ForgotPassword(Request $request)
    {
        try {
            $chk_email_exists = User::where('email', $request->email)->orWhere('username', $request->email)->first();
            if (empty($chk_email_exists)) {
                return response::json(['status' => 1, 'forgot_password' => null, 'message' => ['Email id is not registered.']]);
            } else {
                $str = rand();
                $result = hash("sha256", $str);
                $to_email = $request->email;
                $data = [
                    'email' => $to_email,
                    'forgot_token' => $result,
                ];
                Mail::send('emails.forgot_password', $data, function ($message) use ($to_email) {
                    $message->to($to_email)
                        ->subject('Forgot Password');
                    $message->from('noreply@rummyboss.com', 'Password Reset for Rummy Boss');
                });
                User::where('email', $request->email)->update(['forgot_token' => $result]);
                return response::json(['status' => 1, 'forgot_password' => null, 'message' => ['Please check your email.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'registration' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function AppSettings(Request $request)
    {
        try {
            $in = $request->all();

            $validator = Validator::make($request->all(), [
                'sound' => 'required|integer|gt:-1|lt:2',
                'vibrate' => 'required|integer|gt:-1|lt:2',
                'chat' => 'required|integer|gt:-1|lt:2',
            ], [
                'sound.gt' => 'Invalid sound value',
                'sound.lt' => 'Invalid sound value',
                'vibrate.gt' => 'Invalid vibrate value',
                'vibrate.lt' => 'Invalid vibrate value',
                'chat.gt' => 'Invalid chat value',
                'chat.lt' => 'Invalid chat value',
            ]);

            if (!$validator->passes()) {
                return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
            }


            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $user = User::where('id', $request->user_id)->first();
                $sound = $user->sound;
                $vibrate = $user->vibrate;
                $chat = $user->chat;
                $profile = $user->profile;
                $flag = false;
                if (isset($in['sound']) && $in['sound'] != $sound) {
                    $sound = $in['sound'];
                    $flag = true;
                }
                if (isset($in['vibrate'])  && $in['vibrate'] != $vibrate) {
                    $flag = true;
                    $vibrate = $in['vibrate'];
                }
                if (isset($in['chat']) && $in['chat'] != $chat) {
                    $flag = true;
                    $chat = $in['chat'];
                }
                if (isset($in['profile'])  && $in['profile'] != $profile) {
                    $flag = true;
                    $profile = $in['profile'];
                }
                if ($flag) {
                    $data = [
                        'sound' => $sound,
                        'vibrate' => $vibrate,
                        'chat' => $chat,
                        'profile' => $profile,
                    ];
                    User::where('id', $in['user_id'])->update($data);
                    $user = User::where('id', $request->user_id)->first();
                    return response::json(['status' => 1, 'app_setting' => $data, 'message' => ['Your setting updated successfully . ']]);
                } else {
                    $data = [
                        'sound' => $sound,
                        'vibrate' => $vibrate,
                        'chat' => $chat,
                        'profile' => $profile,
                    ];
                    $user = User::where('id', $request->user_id)->first();
                    return response::json(['status' => 0, 'app_setting' => $data, 'message' => ['Nothing has changed. ']]);
                }
            } else {
                return response::json(['status' => 0, 'message' => ['User not authenticate . ']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'message' => [$e->getMessage()]]);
        }
    }

    public function KYCVerification(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'bank_account_no' => 'required|numeric',
                'bank_name' => 'required',
                'ifsc_code' => 'required',
                'payee_name' => 'required',
                'account_type' => 'required|gt:-1|lt:2',
                'pancard_no' => 'required|max:10',
                'id_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ], [
                'id_proof.mimes' => 'Profile picture must be in jpeg/jpg/png format.',
                'upload.max' => "Maximum file size to upload is 1MB . If you are uploading a photo, try to reduce its resolution to make it under 8MB",
                'pancard_no.max' => 'Pancard no should be 10 digits',
                'account_type.gt' => 'Invalid account type value',
                'account_type.lt' => 'Invalid account type value',
            ]);

            if (!$validator->passes()) {
                return response::json(['status' => 0, 'message' => $validator->errors()->all()]);
            }

            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $chk_email_verified = $this->user->EmailVerification($request->user_id);
                if ($chk_email_verified) {
                    $chk_mobile_verified = $this->user->MobileVerification($request->user_id);
                    if ($chk_mobile_verified) {
                        if ($request->hasfile('id_proof')) {
                            $image = $request->file('id_proof');
                            $hash = hash_file('sha256', $image, false);
                            $name = $hash . '.' . $image->getClientOriginalExtension();
                            $destinationPath = public_path('/images/id_proofs');
                            $image->move($destinationPath, $name);
                            $image_path = url('public/images/id_proofs') . '/' . $name;
                            $id_proof_image = $image_path;
                            $data = [
                                'bank_account_no' => $request->bank_account_no,
                                'bank_name' => $request->bank_name,
                                'ifsc_code' => $request->ifsc_code,
                                'payee_name' => $request->payee_name,
                                'account_type' => $request->account_type,
                                'pancard_no' => $request->pancard_no,
                            ];
                            $add_id_proof = $this->user->AddIdProofs($request->user_id, $id_proof_image, $data);
                            if ($add_id_proof == 1) {
                                return response::json(['status' => 1, 'kyc_verification' => null, 'message' => ['KYC verification successfully.']]);
                            } else {
                                return response::json(['status' => 0, 'kyc_verification' => null, 'message' => ['Your ID Proof not uploaded successfully, Please try again.']]);
                            }
                        }
                    } else {
                        return response::json(['status' => 0, 'kyc_verification' => null, 'message' => ['Your mobile number is not verified, Please verify it before KYC verification.']]);
                    }
                } else {
                    return response::json(['status' => 0, 'kyc_verification' => null, 'message' => ['Your Email id is not verified, Please verify it before KYC verification.']]);
                }
            } else {
                return response::json(['status' => 0, 'kyc_verification' => null, 'message' => ['No such user present.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'kyc_verification' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function ChangePassword(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $verify_password = $this->user->PasswordVerify($request->old_password, $request->user_id);
                if ($verify_password) {
                    $udate_password = $this->user->UpdatePassword($request->user_id, $request->new_password);
                    if ($udate_password == 1) {
                        return response::json(['status' => 1, 'change_password' => $udate_password, 'message' => ['Your password successfully changed.']]);
                    } else {
                        return response::json(['status' => 0, 'change_password' => null, 'message' => ['Please try again for change password.']]);
                    }
                } else {
                    return response::json(['status' => 0, 'change_password' => null, 'message' => ['Please enter correct password.']]);
                }
            } else {
                return response::json(['status' => 0, 'change_password' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'change_password' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GetAccountInfo(Request $request)
    {
        try {
            // $user = JWTAuth::parseToken()->authenticate();
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $get_account_details = $this->user->GetAccountInfo($request->user_id);
                $get_account_details->profile_pic = ($get_account_details->profile_pic) ? asset("profile_image/{$get_account_details->profile_pic}") : null;
                $get_account_details->icon = ($get_account_details->icon) ? asset("player_ranking/{$get_account_details->icon}") : null;
                return response::json(['status' => 1, 'get_account_info' => $get_account_details, 'rewards' => $this->referRepository->getAllRewards(), 'message' => ['Get account details successfully..']]);
            } else {
                return response::json(['status' => 0, 'get_account_info' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'get_account_info' => null, 'message' => [$e->getMessage()]]);
        }
    }


    public function UserLogin(Request $request)
    {
        try {
            if (isset($request->social_token)) {
                if (SocialRegistration::where('social_token', $request->social_token)->exists()) {
                    return response::json([
                        'status' => 1,
                        'login' => SocialRegistration::where('social_token', $request->social_token)->first(),
                        'message' => 'Login successfully.'
                    ]);
                } else {
                    return response::json([
                        'status' => 0,
                        //'login' => '',
                        'message' => 'You are not registered.'
                    ]);
                }
            } else {

                $user_exists = User::where('username', $request->username)->where('password', hash('sha256', $request->password))->exists();
                $userByDeviceToken = User::where('device_token', $request->device_token);
                if ($user_exists || !empty($userByDeviceToken->first())) {
                    $userdata = User::where('username', $request->username)->where('password', hash('sha256', $request->password))->first();
                    /*if($userdata->active_user == 0){
                        return response::json([
                            'status' => 0,
                           // 'login' => null,
                            'message' => ['Your account is not active.']
                        ]);
                    }else */
                    if (empty($userdata) && isset($request->device_token)) {
                        $userdata = $userByDeviceToken->first();
                        $data = $userdata;
                    } else {
                        # remove previous device token associated with any user and update this with current user
                        if (isset($userdataDeviceToken)) {
                            $userdataDeviceToken = $userByDeviceToken->first();
                            $userdataDeviceToken->device_token = null;
                            $userdataDeviceToken->save();
                        }
                        $userdata->device_token = $request->device_token;
                        $userdata->save();
                        $data = User::select('id', 'username', 'email', 'mobile_number', 'mobile_verified_at', 'email_verified_at', 'api_token', 'sound', 'vibrate', 'chat', 'is_block', 'fcm_token', 'is_deleted', 'active_user', 'profile', 'refer_code', 'user_type')->where('username', $request->username)->where('password', hash('sha256', $request->password))->first();
                    }
                    if ($userdata->is_block == 1) {
                        return response::json([
                            'status' => 0,
                            // 'login' => null,
                            'message' => ['You have been blocked.']
                        ]);
                    } else {


                        // $token = hash('sha256', Str::random(254));
                        $token = JWTAuth::fromUser($userdata);

                        User::where('username', $request->username)->update([
                            'fcm_token' => $request->fcm_token
                        ]);
                        //$credentials = request(['username', 'password']);
                        //$token = auth('api')->attempt($credentials)


                        // $chips = Chip::where('user_id', $data->id)->first();
                        // $totalChips = 0;
                        // if ($chips) {
                        //     $totalChips = $chips->chips_amount;
                        // }
                        //  $data->total_chips = $totalChips;
                        // $data->api_token = $token;
                        // $data->save();

                        //unset($data->save($data->updated_at));
                        return response::json([
                            'status' => 1,
                            'login' => $data,
                            'token' => "Bearer " . $token,
                            'message' => ['Login successful.']
                        ]);
                    }
                } else {
                    return response::json([
                        'status' => 0,
                        'login' => [
                            "id" => null,
                            "username" => null,
                            "email" => null,
                            "mobile_number" => null,
                            "mobile_verified_at" => null,
                            "email_verified_at" => null,
                            "api_token" => null,
                            "sound" => null,
                            "vibrate" => null,
                            "chat" => null,
                            "is_block" => null,
                            "fcm_token" => null,
                            "is_deleted" => null,
                            "active_user" => null,
                            "profile" => null,
                            "refer_code" => null,
                            "user_type" => null,
                            "updated_at" => null
                        ],
                        'message' => ['Please check your credentials.']
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'get_account_info' => null, 'message' => [$e->getMessage()]]);
        }
    }


    // public function UserLogout(Request $request)
    // {
    //     try {
    //         $chk_valid_user = $this->user->ValidUser($request->user_id);
    //         if ($chk_valid_user) {
    //             $get_account_details = $this->user->UserLogout($request->user_id);

    //             return response::json(['status' => 1, 'user_logout' => null, 'message' => ['Logged out successfully.']]);
    //         } else {
    //             return response::json(['status' => 0, 'user_logout' => null, 'message' => ['User does not exists.']]);
    //         }
    //     } catch (\Exception $e) {
    //         return response::json(['status' => 0, 'get_account_info' => null, 'message' => [$e->getMessage()]]);
    //     }
    // }

    /**
     *Log out the user and make the token unusable.
     * @return JsonResponse
     */
    public function UserLogout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        $data = [
            'status' => 1,
            'data' => null,
            'message' => ['Successfully logged out']
        ];
        return response()->json($data);
    }

    /**
     * Renewal process to make JWT reusable after expiry date.
     * @return JsonResponse
     */
    public function refresh()
    {
        $data = [
            'status' => 1,
            'data' => null,
            'token' => auth()->refresh()
        ];
        return response()->json($data, 200);
    }


    public function DeleteUser(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $get_account_details = $this->user->DeleteUser($request->user_id);

                return response::json(['status' => 1, 'message' => ['User Deleted successfully.']]);
            } else {
                return response::json(['status' => 0, 'message' => ['Cannot Delete the user.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'get_account_info' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GetNotificationList(Request $request)
    {
        try {
            $notification_list = Notification::where('send_to', $request->user_id)->where('is_read', null)->get();
            // $notification = json_encode($notification_list);
            // for unity json utility library
            // $notification = str_replace("\"", "\\\"", $notification_list);
            if (!empty($notification_list->toArray())) {
                return response::json(['status' => 1, 'get_notification' => $notification_list, 'message' => ['Get notification list']]);
            } else {
                return response::json(['status' => 1, 'get_notification' => null, 'message' => ['You don\'t have any notifications']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'get_account_info' => null, 'message' => [$e->getMessage()]]);
        }
    }

    /**
     * Verify mobile number through otp
     *
     * @param Request $request
     * @return void
     */
    public function MobileOtpVerification(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $userdata = User::where('id', $request->user_id)->first();
                if ($userdata->mobile_number == $request->mobile_number) {
                    if ($userdata->otp == $request->otp) {
                        User::where('id', $request->user_id)->update([
                            'otp' => null,
                            'mobile_verified_at' => date('Y-m-d H:i:s')
                        ]);
                        $this->referRepository->addVerificationReward($request->user_id);
                        $data = User::where('id', $request->user_id)->first();
                        // $chips = Chip::where('user_id', $request->user_id)->first();
                        // $totalChips = 50;
                        // if ($chips) {
                        //     Chip::where('user_id', $request->user_id)->update([
                        //         'chips_amount' => $chips->chips_amount + 50,
                        //     ]);
                        //     $totalChips = $totalChips + $chips->chips_amount;
                        // } else {
                        //     Chip::create([
                        //         'user_id' => $request->user_id,
                        //         'chips_amount' => 50,
                        //     ]);
                        // }
                        // $data->total_chips = $totalChips;
                        return response::json(['status' => 1, 'data' => $data, 'message' => ['Mobile number has been verified.']]);
                    } else {
                        return response::json(['status' => 0, 'data' => null, 'message' => ['Invalid otp.']]);
                    }
                } else {
                    return response::json(['status' => 0, 'data' => null, 'message' => ['This mobile number does not belong to current user.']]);
                }
            } else {
                return response::json(['status' => 0, 'data' => null, 'message' => ['User is not authenticated.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'data' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function CheckVersion(Request $request)
    {
        try {
            // $chk_valid_user = $this->user->ValidUser($request->user_id);
            // if ($chk_valid_user) {
            $version = Version::orderby('created_at', 'desc')->first();
            if ($version && $request->version < $version->version) {
                return response::json(['status' => 0, 'data' => ["url" => "https://play.google.com/store/apps/details?id=rummyboss.games.rummy", 'force_update' => ($version->force_update) ? true : false], 'message' => ['Kindly update to the latest version of the App']]);
            } else {
                return response::json(['status' => 1, 'data' => null, 'message' => ['The App is updated to the latest version.']]);
            }
            // } else {
            //     return response::json(['status' => 0, 'data' => null, 'message' => ['User is not authenticated.']]);
            // }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'data' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function SendOtp(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            $userdata = User::where('id', $request->user_id)->first();
            if ($chk_valid_user) {
                $sentOtp = null;
                $sentEmail = null;
                if (!$userdata->mobile_verified_at) {
                    $sentOtp = $this->userRegistrationRepository->sendOTP($userdata->mobile_number, $request->user_id);
                }
                // $userdata->token =
                if (!$userdata->email_verified_at) {
                    $userdata->token = Crypt::encrypt($userdata->email);
                    $this->sendVerificationMail($userdata->email, $userdata->toArray());
                    $sentEmail = true;
                }
                if ($sentOtp && $sentEmail) {
                    return response::json(['status' => 1, 'data' => null, 'message' => ['OTP has been sent to the registered mobile number.', 'An email has been sent to your registered email id']]);
                } elseif ($sentEmail) {
                    return response::json(['status' => 1, 'data' => null, 'message' => ['An email has been sent to your registered email id']]);
                } elseif ($sentOtp) {
                    return response::json(['status' => 1, 'data' => null, 'message' => ['OTP has been sent to the registered mobile number.']]);
                } elseif ($userdata->email_verified_at && $userdata->mobile_verified_at) {
                    return response::json(['status' => 1, 'data' => null, 'message' => ['Communication details already verified']]);
                } else {
                    return response::json(['status' => 0, 'data' => null, 'message' => ['Something went wrong while sending OTP.']]);
                }
            } else {
                return response::json(['status' => 0, 'data' => null, 'message' => ['User is not authenticated.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'data' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function clearNotification(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $n = Notification::where('send_to', $user->id)->update(['is_read' => '1']);
            return response::json(['status' => 1, 'data' => $n, 'message' => ['Notifications cleared.']]);
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'message' => [$e->getMessage()]]);
        }
    }
}
