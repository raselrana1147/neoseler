<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Aorder;
use App\Transaction;
use App\helpers\SMS;

class AffiliteOrderController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth:admin');
         //$this->middleware('merchant');
     }

     public function index(){

     	$orders=Aorder::all();
     	return view('admin.aorder.index',compact('orders'));
     }


     public function updateaffststus(Request $request)
     {


          //return url()->current();
     	
     	 $orderid=$request->oid;

     	 $aorder =Aorder::findorfail($orderid);
 
     	 $aorder->pay_status=$request->pay_status;
     	 $aorder->order_stutus=$request->delivery_status;
     	 $aorder->save();

     	 $message=$this->statusType($request->delivery_status,$orderid);

     	 $to=$aorder->customer_phone;
     	 $get=SMS::sendSms(urlencode($message),$to);
     	 if ($get) {
     	 	$notification=array(
     	 	       'rmessage'=>'Succcessfully done',
     	 	       'alert-type'=>'success'
     	 	        );
     	 	  return Redirect()->to('admin/affilate-order')->with($notification);
                      //return back()->with($notification);
     	     //$msg = 'Status Updated Successfully.';

     	    
     	 }else{
     	     return back();
     	 }

     	 

     }

     public function statusType($value,$id){

     	$aorder =Aorder::findorfail($id);
     	$order_number=$aorder->order_number;
     	
     	switch ($value) {
     	    case 'pending':

     	    $message="Congratulations! You have successfully placed your order from Oferri.com. Your order id is".$order_number.". Soon we'll contact for confirming your order.";
     	        break;

     	        case 'processing':
     	           $message="Dear customer, your order ".$order_number." has been confirmed. Thanks for shopping with Oferri.com.";
     	            break;

     	       case 'on delivery':
     	        $message="Dear customer, your order ".$order_number." is sending through Sundarban courier service. Your tracking ID. Please follow the link for tracking your product lacation. Thank you.";
     	       break;

     	       case 'completed':
     	          $message="Dear customer, your order ".$order_number." has delivered successfully. Thank you for choosing Oferri.com";



     	           break;
     	       case 'declined':
     	           $message="Order".$order_number." has been cancled by customer. -Oferri.com.";
     	           break;
     	    default:
     	        break;
     	}

     	return $message;


     }

public function details($id)
{
	$aorder=Aorder::findOrFail($id);

	return view('admin.aorder.details',compact('aorder'));

}

public function invoice($id){

	$aorder=Aorder::findOrFail($id);
	return view('admin.aorder.invoice',compact('aorder'));
}

public function print($id){
	
	$aorder=Aorder::findOrFail($id);
	return view('admin.aorder.print',compact('aorder'));
}



}
