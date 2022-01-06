<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class APIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next)
	{
	  if($request->header('Authorization') && $request->user_id)
	  {
		$eToken = User::GetUserApiToken($request->user_id);
		if(!is_null($eToken) )
		{
			if( $eToken->api_token == $request->header('Authorization'))
				return $next($request);
			else
				return response()->json([
					'status' => 0,'message' => ['Not valid API token.'],
				]);
		}
		else
		{
			return response()->json([
				    'status'=> 0,
					'message' => ['User not found or active!!.'],
				]);
		}
	  }
	  return response()->json([
	  	'status'=> 0,
		'message' => ['Not a valid API request.'],
	  ]);
	}
}
