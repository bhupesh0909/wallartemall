<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRegistrationRequest;
use App\Http\Requests\UpdateUserRegistrationRequest;
use App\Repositories\UserRegistrationRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Crypt;
use Response;
use Auth;
use Illuminate\Support\Facades\Hash;
use DataTables, DB;
use Illuminate\Support\Facades\Mail;
use App\Repositories\ReferRepository;
class UserRegistrationController extends AppBaseController
{
    /** @var  UserRegistrationRepository */
    private $userRegistrationRepository;
    private $referRepository;

    public function __construct(UserRegistrationRepository $userRegistrationRepo, ReferRepository $referRepo)
    {
        $this->userRegistrationRepository = $userRegistrationRepo;
        $this->referRepository = $referRepo;
    }

    /**
     * Display a listing of the UserRegistration.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $search = "";
        // if($request->input('search') != ''){
        //     $search = $request->input('search');  
        // }
        
        // //$userRegistrations = $this->userRegistrationRepository->all();
        // if(!empty($search)){
        //     $userRegistrations = User::select('id', 'username', 'email', 'dob', 'gender', 'state', 'is_block',
        //     'mobile_verified_at', 'email_verified_at', 'kyc_verification','created_at')
        //     ->where('role', 'user')
        //     ->where('username','like','%'.$search.'%')
        //     ->paginate(15);
			
        //     return view('user_registrations.index')
        //         ->with('userRegistrations', $userRegistrations);
        // }
        // else{
        //     $userRegistrations = User::select('id', 'username', 'email', 'dob', 'gender', 'state', 'is_block',
        //     'mobile_verified_at', 'email_verified_at', 'kyc_verification','created_at')
        //     ->where('role', 'user')
        //     ->paginate(15);
        //     return view('user_registrations.index')
        //         ->with('userRegistrations', $userRegistrations);   
        // }
        return view('user_registrations.index');
    }

    public function datatable(Request $req){
        // dd($req->all());
        $cols = ['id', 'username', 'email', 'dob', 'gender', 'state', 'is_block',
        'mobile_verified_at', 'email_verified_at', 'kyc_verification','created_at'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = User::where('role', 'user')->count();
        $userRegistrations = User::select('id', 'username', 'email', DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'), 'gender', 'state', 'is_block',
            'mobile_verified_at', 'email_verified_at', 'kyc_verification','created_at');
        for($i = 0; $i < count($cols); $i++){
            $userRegistrations = $userRegistrations->orWhere($cols[$i], 'like', "%{$search}%");
        }
        $userRegistrations = $userRegistrations->where('role', 'user');
        // if(isset($start) && isset($length)){
        //     $userRegistrations = $userRegistrations->limit($length)->offset($start);
        // }
        if($order){
            $userRegistrations = $userRegistrations->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $userRegistrations = $userRegistrations->orderBy('id', 'DESC');
        }
        $userRegistrations = $userRegistrations->get();
        // return response()->json([
        //     "draw"=>1,
        //     "recordsTotal"=>$recordsTotal,
        //     "recordsFiltered"=>count($userRegistrations),
        //     "data"=>$userRegistrations,
        // ]);
        return DataTables::of($userRegistrations)->make(true);
    }

    /**
     * Show the form for creating a new UserRegistration.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_registrations.create');
    }

    /**
     * Store a newly created UserRegistration in storage.
     *
     * @param CreateUserRegistrationRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $userRegistration = User::create($input);

        Flash::success('User Registration saved successfully.');

        return redirect(route('userRegistrations.index'));
    }

    /**
     * Display the specified UserRegistration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userRegistration = User::find($id);

        if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }

        return view('user_registrations.show')->with('userRegistration', $userRegistration);
    }

    /**
     * Show the form for editing the specified UserRegistration.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function edit($id)
    // {

    //     $userRegistration = User::find($id);

    //     if (empty($userRegistration)) {
    //         Flash::error('User Registration not found');

    //         return redirect(route('userRegistrations.index'));
    //     }

    //     return view('user_registrations.edit')->with('userRegistration', $userRegistration);
    // }

    /**
     * Update the specified UserRegistration in storage.
     *
     * @param int $id
     * @param UpdateUserRegistrationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRegistrationRequest $request)
    {

         
        $userRegistration = User::find($id);

        if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }

        $arr = $request->all();
        unset($arr['_method']);
        unset($arr['_token']);
        // unset($arr['social_media']);

        User::where('id', $id)->update($arr);

        // $userRegistration = User::update($request->all(), $id);

        Flash::success('User Registration updated successfully.');

        return redirect(route('userRegistrations.index'));
    }

	
	// update admin profile
	 public function editProfile($id)
    {
        
        $userRegistration = User::find($id);

        if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }

        return view('profile.edit')->with('userRegistration', $userRegistration);
    }
	
	public function updateProfile($id,UpdateUserRegistrationRequest $request)
    {
        echo "hi m gere";
        exit;
		//$id = Auth::user()->id;
        $userRegistration = User::find($id);
	
		
        if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }

        $arr = $request->all();
        unset($arr['_method']);
        unset($arr['_token']);
        // unset($arr['social_media']);

		//dd($arr);
		
        User::where('id', $id)->update($arr);

        // $userRegistration = User::update($request->all(), $id);

        Flash::success('User Registration updated successfully.');
		$userRegistration = User::find($id);
        return view('profile.edit')->with('userRegistration', $userRegistration);
    }

	public function changePassword($id, Request $request)
    {
		//$id = Auth::user()->id;
        $userRegistration = User::find($id);
		
		
		  if (Request()->post()) {
			 $request->validate([
				  'oldPassword' => 'required',
				  'new_password' => 'required|min:8',
				  'cPassword' => 'required|same:new_password',
				],[
					'oldPassword.required'=>'The old password required.',
					'new_password.required'=>'The new password required.',
					'new_password.min' => 'New password must be minimum 8 characters.',
					'cPassword.required'=>'The confirm password required.',
					'cPassword.same'=>'The new password and confirm password does not match.',
				]);
			 }
		if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }

       $arr = $request->all();
        unset($arr['_method']);
        unset($arr['_token']);
      		$user = User::find($id);
			
			 if (Hash::check($request->oldPassword, $user->password)) { 
               $user->fill([
                'password' => Hash::make($request->new_password)
                ])->save();

               Flash::success('Password updated successfully.');

            } else {
                Flash::error('Current password does not match.');
            }
		   return view('profile.edit')->with('userRegistration', $userRegistration);
    }

	
    /**
     * Remove the specified UserRegistration from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userRegistration = User::find($id);

        if (empty($userRegistration)) {
            Flash::error('User Registration not found');

            return redirect(route('userRegistrations.index'));
        }
        // User::where('id', $id)->delete();
       $this->userRegistrationRepository->delete($id);

        Flash::success('User Registration deleted successfully.');

        return redirect(route('userRegistrations.index'));
    }

    public function SetPassword($forgot_token)
    {
        try {
            $is_token_exists = User::where('forgot_token', $forgot_token)->exists();
            if ($is_token_exists) {
                return view('emails.save_password', compact('forgot_token'));
            } else {
                $token_expired = 3;
                return view('emails.index', compact('token_expired'));
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'forgot_password' => [], 'message' => $e->getMessage()]);
        }
    }

    public function UpdatePassword(Request $request)
    {
        try {
            User::where('forgot_token', $request->forgot_token)->update([
                'password' => hash("sha256", $request->password),
                'forgot_token' => ''
            ]);
            $password_updated = 1;
            return view('emails.index', compact('password_updated'));
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'forgot_password' => [], 'message' => $e->getMessage()]);
        }
    }

    public function UserAction($user_id)
    {
        $is_user_blocked = User::where('id', $user_id)->first();
        if ($is_user_blocked->is_block == 1) {
            User::where('id', $user_id)->update(['is_block' => '0']);
        } else {
            User::where('id', $user_id)->update(['is_block' => '1']);
        }
        return redirect()->back();
    }

    public function ConfirmEmail($token)
    {
        $result = Crypt::decrypt($token);
        $user = User::where('email', $result)->first();
        $user->update(['email_verified_at' => Carbon::now()]);
        //send email verification success mail
        $to_email = $user->email;
        $username = $user->username;
        $this->referRepository->addVerificationReward($user->id);
        Mail::send('emails.email_verified', compact('username'), function ($message) use ($to_email) {
            $message->to($to_email)
                ->subject('Rummyboss email verified successfully');
            $message->from('noreply@rummyboss.com', 'Email Verified');
        });

        $email_verified = 1;
        return view('emails.index', compact('email_verified'));
    }

    public function userActivity($id){
        $user_id = $id;
        return view('user_registrations.user_activity', compact('user_id'));
//         SELECT u.id, u.username, pg.game_type, pg.game_id, pg.entry_fee, pg.created_at as game_date, gt.game_type, gw.status, gw.win_amount, gw.created_at as result_date FROM users as u
// JOIN play_games as pg ON pg.user_id = u.id 
// JOIN game_types as gt ON gt.id = pg.game_id
// LEFT JOIN game_winner as gw ON gw.user_id = u.id AND gw.game_id = gt.id
// WHERE u.id = 83 -- AND status = 'LOSS'
    }

    public function userActivityDataTable(Request $req){
        $cols = ['users.id', 'users.username', 'pg.game_type as game_type', 'pg.game_id', 'pg.entry_fee', 'pg.created_at as game_date', 
        'gt.game_type as game_name', 'gw.status', 'gw.win_amount', 'gw.created_at as result_date', 't_format as tournament_name'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $data = User::select($cols)
                ->from('users')
                ->join('play_games as pg', 'pg.user_id', '=', 'users.id')
                ->join('game_types as gt', 'gt.id', '=', 'pg.game_id')
                ->join('game_winner as gw', 'gw.room_id', '=', 'pg.id')
                ->leftjoin('game_tournaments as gt2', 'gt2.id', '=', 'pg.id')
                ->where('users.id', $req->user_id);
        $recordsTotal = $data->count();
        // for($i = 0; $i < count($cols); $i++){
        //     $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
        // }
        $data = $data->where('role', 'user');
        // if(isset($start) && isset($length)){
        //     $data = $data->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('id', 'DESC');
        }
        // dd($data->toSql(), $data->getBindings());
        $data = $data->get();
        // return response()->json([
        //     "draw"=>1,
        //     "recordsTotal"=>$recordsTotal,
        //     "recordsFiltered"=>count($data),
        //     "data"=>$data,
        // ]);
        return DataTables::of($data)->make(true);
    }
}
