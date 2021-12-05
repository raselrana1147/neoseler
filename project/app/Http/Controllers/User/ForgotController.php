<?php

namespace App\Http\Controllers\User;

use App\Models\Generalsetting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use App\helpers\SMS;
use Hash;


class ForgotController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgotForm()
    {
      return view('user.forgot');
    }


    public function forgot(Request $request)
    {

      $this->validate($request,[
          'phone'=>'required'
      ],['phone.required'=>'Enter phone number']);

      $user=User::where('phone',$request->phone)->first();

      if (!is_null($user)) {
              $verifycode=$varifycode=rand(10000,99999);
              $user->verifycode=$verifycode;
              $user->save();

              $to=$user->phone;

                $message="Dear user, your OTP code: ".$verifycode.", Use this for signup completion, It will expire in 10 minutes";

              $get=SMS::sendSms(urlencode($message),$to);

              if ($get) {
                 session()->flash('lobiboxsuccess','You have been sent varifycode in your phone');

                  Session::put('user_id',$user->id);

                 return redirect('user/forget-password_now');
              }else{
                session()->flash('lobiboxerror','Something went wrong. Please contact with admin');
                return back();
              }
              
      }else{ 
        session()->flash('lobiboxerror','No user fount for this phone');
        return back();
      }
      
    }

    public function imagedownload($id){
        return $id;
    }


    public function recoverpassword(Request $request)
    {
       $this->validate($request,[
          
          'verifycode'=>'required',
          'password'=>'required|min:4',
      ],[
         'verifycode.required'=>'Enter verify code',
         'password.required'=>'Enter password'
      ]);

       $user=User::where('verifycode',$request->verifycode)->first();
       if (!is_null($user)) {

               $updated = new Carbon($user->updated_at);
               $now = Carbon::now();
               $diff_in_minutes = $now->diffInMinutes($updated);

               if($diff_in_minutes > 10){

                 $v="<a href='resendcode'> <b> Click here to resend code</b></a>";

              Session::flash('errormessage','Your verify code has been expired.'.$v);
              Session::put('user_id', $user->id);
              return back();

               }else{
                   
                  $user->password=Hash::make($request->password);
                  $user->verifycode=NULL;
                  $user->save();
                  //=send sms==
                  $password=$request->password;
                  $to=$user->phone;

                     $message="Dear user your password has been recovered successfully. Your new password is ".$password." Thank you.";

                     $get=SMS::sendSms(urlencode($message),$to);

                     if ($get) {
                      Session::put('user_id',NULL);
                     Session::flash('rmessage', 'Your password has been recovered');
                     return redirect('user/login');

                     }else{
                        Session::flash('errormessage', 'Something went wrong');
                        return redirect()->back();

                     }

                  
               }
       }else{
           session()->flash('lobiboxerror','Invalid verification code');
           return back();
       }



    }

    public function forgotform(){

      return view('user.forgetpassword');

    }

    //=====================From here my code stated============



}
