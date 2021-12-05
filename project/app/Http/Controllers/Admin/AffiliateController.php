<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AffiliateM;
use App\Models\User;
use App\helpers\SMS;
use Session;

class AffiliateController extends Controller
{
    public function __construct()
     {
        $this->middleware('auth:admin');
        

     }

     public function index(){
      return "ok";
     		$amember=AffiliateM::all();
     		return view('admin.affiliate.index',compact('amember'));
     }


     public function activemember($id){

         $amember=AffiliateM::find($id);
         $amember->active=1;
         $amember->save();
         $username=$amember->username;

          $user_id=$amember->user_id;
          $user=User::where('id',$user_id)->first();

         

             $message="Congratulations! You are now a member of our team oferri.com. Your username is ".$username.". Hope we have a long journey together. Dont't miss the chnage to get additional 200 TK bonus by getting 3 orders within first 7 days. Best of luck.";

          //===sms code here====
           $to= $user->phone;
           $get=SMS::sendSms(urlencode($message),$to);

           if ($get) {
               Session::flash('rmessage', 'The affiliate membership has been successfully actived ');
                return back();

           }else{
               Session::flash('errormessage', 'Something wents wrong. Please try again');
               return back();
           }

     }

    
}
