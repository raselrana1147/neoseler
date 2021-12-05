<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\helpers\SMS;
use Session;

class ApplyController extends Controller
{
   

	public function showForm(){

			return view('user.apply');
	}

	public function store(Request $request){

		$this->validate($request,[
		    		'phone'   =>'required|unique:applies,phone|max:11|min:11',
		    		 'email'   =>'required|unique:applies,email|email'
		    	],[
		            'phone.unique'=>'This phone number is already used',
		            'email.unique'=>'This email is already used'
		        ]);

		        $user=Apply::create([
		            'name'         =>$request->name,
		            'phone'        =>$request->phone,
		            'email'        =>$request->email,
		            'businessname' =>$request->bussinessname, 
		        ]);
		         $message="Dear ".$request->name.", your application as a merchant is sent successfully. you will get response within 24 hours";

		       //===sms code here====
		        $to=$request->phone;
		        $get=SMS::sendSms(urlencode($message),$to);

		        if ($get) {
		            Session::flash('rmessage', 'Your application is sent successfully.');
		            return redirect(route('merchant.apply'));

		        }else{
		            Session::flash('rmessage', 'Something wents wrong. Please try again');
		            return back();
		        }
	}

}
