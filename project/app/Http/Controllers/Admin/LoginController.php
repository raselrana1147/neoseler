<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use App\helpers\SMS;


class LoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('admin.login');
    }

    public function login(Request $request)
    {
        //--- Validation Section
        $rules = [
                  'phone'   => 'required',
                  'password' => 'required'
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return response()->json(route('admin.dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
          return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));     
    }

    public function showForgotForm()
    {
      return view('admin.forgot');
    }

    public function forgot(Request $request)
    {
      $gs = Generalsetting::findOrFail(1);
      $input =  $request->all();
      if (Admin::where('phone', '=', $request->phone)->count() > 0) {
      // user found
      $admin = Admin::where('phone', '=', $request->phone)->firstOrFail();
      $autopass = str_random(8);
      $input['password'] = bcrypt($autopass);
      $admin->update($input);

      $message="Dear user, your password has been reset successfully. Your new Password is: ".$autopass." Please login your shop.";

       //===sms code here====
        $to=$request->phone;
        $get=SMS::sendSms(urlencode($message),$to);

      // $subject = "Reset Password Request";
      // $msg = "Your New Password is : ".$autopass;
      // if($gs->is_smtp == 1)
      // {
      //     $data = [
      //             'to' => $request->email,
      //             'subject' => $subject,
      //             'body' => $msg,
      //     ];

      //     $mailer = new GeniusMailer();
      //     $mailer->sendCustomMail($data);                
      // }
      // else
      // {
      //     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
      //     mail($request->email,$subject,$msg,$headers);            
      // }
      return response()->json('Your Password Reseted Successfully. Please Check your phone for new Password.');
      }
      else{
      // user not found
      return response()->json(array('errors' => [ 0 => 'No Account Found With This Phone.' ]));    
      }  
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
