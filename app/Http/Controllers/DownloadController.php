<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index($mobile_number){

      $message = 'Dear User,
Please find the download link of RB app as requested: https://play.google.com/store/apps/details?id=rummyboss.games.rummy';
      $url='http://www.bulksmsapps.com/api/apismsv2.aspx?apikey=97d7ce77-bcf3-4901-b39a-f3cd38eece31&sender=SMSAPP&number='.$mobile_number.'&message='.urlencode($message);   
     
      if(file_get_contents($url)){
              echo 1;
          }else{
              echo 2;
         }      
   }
}
