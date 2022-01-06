<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class TestController extends Controller
{
    //
	/*  public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    } */
	
	 public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
		$password =  hash('sha256', $request->password) ;

	//	dd(Auth::once(["email"=>$request->email, "password" => $password]));

	//	dd( JWTAuth::attempt(["email"=>$request->email, "password" => $password]));
		$uid = auth('api')->attempt(["email"=>$request->email, "password" => $password]);
		dd($uid);
		//$s=$uid->get('id')->first();
		
		
		$iifuser = User::PasswordVerify($request->password, $uid);
		
        if ($iifuser) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

	protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
	
	public function guard()
    {
        return Auth::guard();
    }
}
