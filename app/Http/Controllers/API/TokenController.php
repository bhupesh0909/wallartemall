<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TokenController extends Controller
{
	
	public function validatesession($sessionid)
	{
		$s = \DB::select("select * from token where active='yes' and session=? ", [$sessionid]);
		//var_dump($s);
				
		if(!empty($s))
		{
			$time = strtotime($s[0]->validity);

			if (($time - time()) <= 900)
				return "validsession";
			else
				return "invalidsession";
		}
		else
			return "invalidsession";
	}
	
	public function showsession($sessionid)
	{

		$s = \DB::select("select * from token where session=? ", [$sessionid]);
		//var_dump($s);
				
		if(!empty($s))
		{
			$arr = array("sessionid"=>$s[0]->session, "sessiontime"=>$s[0]->validity, "active"=>$s[0]->active, "created"=>$s[0]->created_at, "updated"=>$s[0]->updated_at );
			
			return  $arr;
		}
		else
			return "invalidsession";
	}

    static function newsession($sid, $stime)
	{
		
		$time = Carbon::createFromTimestamp($stime);

		$plact = \DB::insert("insert into token (`created_at`, `session`, `validity`, `active`)
										values (?,?,?,?)", [ date('Y-m-d H:i:s'),$sid, $time, 'yes']);
										
		return  array('sessionid'=>$sid, 'sessiontime'=>$stime);
	}
	
	public function resetsession($sid)
	{
		\DB::table('token')
            ->where('session', $sid)
            ->update(['active'=>'no', 'validity'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
		
	//	$plact = \DB::update("update session set(`active`, validity, `updated_at`)
	//									values (?,?,?)", [ 'no', null, date('Y-m-d H:i:s')]);
		return  response(array('sessionid'=>"", 'sessiontime'=>""), 200);
	}
	
	public function updatevalidity($sid, $stime)
	{
		$time = Carbon::createFromTimestamp($stime);
		//$time = strtotime($stime);
	
		$st = \DB::table('token')
            ->where('session', $sid)
            ->update(['validity' => $time, 'updated_at'=>date('Y-m-d H:i:s')]);
			
		if($st)	
			return 'updated';
		else
			return 'notupdated';
	}
	
	public function getsession()
	{
		$ss = $this->newsession(Session::getId(), time() + 900);
		return  response($ss, 200);
	}
}
