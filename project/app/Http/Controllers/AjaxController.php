<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AffiliateM;
use App\helpers\SMS;
use App\Models\User;
use App\Aorder;

class AjaxController extends Controller
{

    
    public function causer($username){

    	$message=array();
    	$username=User::where('ref_user',$username)->first();
    	if (is_null($username)) {
    	  $message=['status'=>1,'msg'=>'Username is availale'];
    	}else{
    	  $message=['status'=>0,'msg'=>'Username name is already exist'];
    	}

    	return json_encode($message);
      

    }

    public function rejecta($id){

    	$message=array();
    	  
    	$data=AffiliateM::findOrFail($id);

    	  $smg="We,er sorry to inform you that we couldn't proccess your request for afilate membership at this momment. Please call us for more information. Thnaks. oferri.com";
    	 
    	 $user=User::where('id',$data->user_id)->first();
         $to=$user->phone;

    	
    	  $get=SMS::sendSms(urlencode($smg),$to);
         $data->delete();
    	  if ($get) {
    	     return back()->with('rmessage','Your application has been rejected successfully.');
    	  	
    	  }else{
    	    Session::flash('errormessage', 'Something wents wrong. Please try again');
    	     return back();
    	  }


    	// if ($data->delete()) {

    	   
    	     

    	 

    	//    $message=['status'=>1,'msg'=>'Membership rejected successfully'];
    	// }else{
    	//   $message=['status'=>0,'msg'=>'Something went wrong'];
    	// }
    	// return json_encode($message);

    }

    public function detailsale($order_id){
        $order=Aorder::find($order_id);
        return json_encode($order);
    }
    public function sort($cat){
        
    }


}
