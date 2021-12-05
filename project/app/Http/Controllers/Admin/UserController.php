<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Currency;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use App\helpers\SMS;
use App\Transaction;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerMessege;


class UserController extends Controller
{
	public function __construct()
	    {
	        $this->middleware('auth:admin');
	        $this->middleware('superadmin',['only'=>['index','withdraws','image']]);
	    }

	    //*** JSON Request
	    public function datatables()
	    {
	       //                         <a href="' . route('admin-user-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a data-href="' . route('admin-user-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a>
	       //                         <a href="javascript:;" class="send" data-email="'. $data->email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>'.
	       //                         '<a href="javascript:;" data-href="' . route('admin-user-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>
	       //                        
	       
	       
	         $datas = User::orderBy('id')->get();
	         //--- Integrating This Collection Into Datatables
	         return Datatables::of($datas)
	         					->editColumn('ref_user',function(User $user){
	         						return $user->ref_user;
	         					})
	                            ->addColumn('action', function(User $data) {
                          
	                                return '<div class="action-list">
	                                <a href="' . route('admin-user-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>'.
	                                '<a href="javascript:;" data-href="' . route('admin-user-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>
	                                <a href="javascript:;" class="send get-modal" userId="'.$data->id.'" data-toggle="modal" data-target="#detuchedMoney"><i class="fas fa-trash-alt"></i>Detuched money</a></div>';
	                            }) 
	                            ->rawColumns(['action'])
	                            ->toJson(); //--- Returning Json Data To Client Side
	    }

	    //*** GET Request
	    public function index()
	    {
	        return view('admin.user.index');
	    }

        //*** GET Request
        public function image()
        {  
            return view('admin.generalsetting.user_image');
        }

	    //*** GET Request
	    public function show($id)
	    {
	        $data = User::findOrFail($id);
	        return view('admin.user.show',compact('data'));
	    }

        //*** GET Request
        public function ban($id1,$id2)
        {
            $user = User::findOrFail($id1);
            $user->ban = $id2;
            $user->update();

        }

	    //*** GET Request    
	    public function edit($id)
	    {
	        $data = User::findOrFail($id);
	        return view('admin.user.edit',compact('data'));
	    }

	    //*** POST Request
	    public function update(Request $request, $id)
	    {
	        //--- Validation Section
	        $rules = [
	               'photo' => 'mimes:jpeg,jpg,png,svg',
	                ];

	        $validator = Validator::make(Input::all(), $rules);
	        
	        if ($validator->fails()) {
	          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
	        }
	        //--- Validation Section Ends

	        $user = User::findOrFail($id);
	        $data = $request->all();
	        if ($file = $request->file('photo'))
	        {
	            $name = time().$file->getClientOriginalName();
	            $file->move('assets/images/users',$name);
	            if($user->photo != null)
	            {
	                if (file_exists(public_path().'/assets/images/users/'.$user->photo)) {
	                    unlink(public_path().'/assets/images/users/'.$user->photo);
	                }
	            }
	            $data['photo'] = $name;
	        }
	        $user->update($data);
	        $msg = 'Customer Information Updated Successfully.';
	        return response()->json($msg);   
	    }

	    //*** GET Request Delete
		public function destroy($id)
		{

		$user = User::findOrFail($id);

        if($user->reports->count() > 0)
        {
            foreach ($user->reports as $gal) {
                $gal->delete();
            }
        }

        if($user->ratings->count() > 0)
        {
            foreach ($user->ratings as $gal) {
                $gal->delete();
            }
        }

        if($user->notifications->count() > 0)
        {
            foreach ($user->notifications as $gal) {
                $gal->delete();
            }
        }

        if($user->wishlists->count() > 0)
        {
            foreach ($user->wishlists as $gal) {
                $gal->delete();
            }
        }

        if($user->withdraws->count() > 0)
        {
            foreach ($user->withdraws as $gal) {
                $gal->delete();
            }
        }

        if($user->socialProviders->count() > 0)
        {
            foreach ($user->socialProviders as $gal) {
                $gal->delete();
            }
        }

        if($user->comments->count() > 0)
        {
            foreach ($user->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }

        if($user->replies->count() > 0)
        {
            foreach ($user->replies as $gal) {
                $gal->delete();
            }
        }
        
        if($user->withdraws->count() > 0)
        {
            foreach ($user->withdraws as $gal) {
                $gal->delete();
            }
        }


        if($user->conversations->count() > 0)
        {
            foreach ($user->conversations as $gal) {
            if($gal->messages->count() > 0)
            {
                foreach ($gal->messages as $key) {
                    $key->delete();
                }
            }
            if($gal->notifications->count() > 0)
            {
                foreach ($gal->notifications as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }

		    //If Photo Doesn't Exist
		    if($user->photo == null){
		        $user->delete();
			    //--- Redirect Section     
			    $msg = 'Data Deleted Successfully.';
			    return response()->json($msg);      
			    //--- Redirect Section Ends 
		    }
		    //If Photo Exist
		    if (file_exists(public_path().'/assets/images/users/'.$user->photo)) {
		            unlink(public_path().'/assets/images/users/'.$user->photo);
		    }
		    $user->delete();
		    //--- Redirect Section     
		    $msg = 'Data Deleted Successfully.';
		    return response()->json($msg);      
		    //--- Redirect Section Ends    
		}

	    //*** JSON Request
	    public function withdrawdatatables()
	    {
	         $datas = Withdraw::where('type','=','user')->orderBy('id','desc')->get();
	         //--- Integrating This Collection Into Datatables
	         return Datatables::of($datas)
	                            ->addColumn('email', function(Withdraw $data) {
	                            	$email = $data->user->email;
	                            	return $email;
	                            }) 
	                            ->addColumn('phone', function(Withdraw $data) {
	                            	$phone = $data->user->phone;
	                            	return $phone;
	                            }) 
	                            ->editColumn('status', function(Withdraw $data) {
	                            	$status = ucfirst($data->status);
	                            	return $status;
	                            }) 
	                            ->editColumn('amount', function(Withdraw $data) {
	                            	$sign = Currency::where('is_default','=',1)->first();
	                            	$amount = $sign->sign.round($data->amount * $sign->value , 2);
	                            	return $amount;
	                            }) 
	                            ->addColumn('action', function(Withdraw $data) {
	                            	$action = '<div class="action-list"><a data-href="' . route('admin-withdraw-show',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i> Details</a>';
	                            	if($data->status == "pending") {
	                            	$action .= '<a data-href="' . route('admin-withdraw-accept',$data->id) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="fas fa-check"></i> Accept</a><a data-href="' . route('admin-withdraw-reject',$data->id) . '" data-toggle="modal" data-target="#confirm-delete1"> <i class="fas fa-trash-alt"></i> Reject</a>';
	                            	}
	                            	$action .= '</div>';
	                                return $action;
	                            }) 
	                            ->rawColumns(['name','action'])
	                            ->toJson(); //--- Returning Json Data To Client Side
	    }

	 


	    //*** GET Request
	    public function withdraws()
	    {
	        return view('admin.user.withdraws');
	    }

	    //*** GET Request	    
	    public function withdrawdetails($id)
	    {
	    	$sign = Currency::where('is_default','=',1)->first();
	        $withdraw = Withdraw::findOrFail($id);
	        return view('admin.user.withdraw-details',compact('withdraw','sign'));
	    }

// merchant
	    public function acceptWithdraw($id){

	             $withdraw = Withdraw::findOrFail($id);
	             $data['status'] = "completed";
	             $withdraw->update($data);
	     	    //--- Redirect Section  
	            $transnumber=mt_rand(1000000000, 9999999999);

	     	    $trans=new Transaction;  

	     	    $trans->transid  =$transnumber;
	     	    $trans->amount   =$withdraw->amount;
	     	    $trans->transtype=2;
	     	    $trans->user_id  =$withdraw->user_id;
	     	    $trans->save();

	     	    $message="Dear Merchant, Your withdrawal request from neoseller.com.bd has been completed. Tk ".$withdraw->amount." has been ".$withdraw->method." Transaction ID ".$transnumber."."; 

	     	    $admin = DB::table('admins')->where('id', $withdraw->user_id)->first();
	     	    $to=$admin->phone;
	     	    $get=SMS::sendSms(urlencode($message),$to);
	     	    if ($get) {
	     	    	$notification=array(
	     	    	   'rmessage'=>'Successfully accepted',
	     	    	   'alert-type'=>'success'
	     	    	);
	     	    	return back()->with($notification);
	     	    } 
	    }




    public function rejectwithdrawal($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        $account = Admin::findOrFail($withdraw->user_id);

        $account->balance = $account->balance + $withdraw->amount + $withdraw->fee;
        $account->update();

        $data['status'] = "rejected";
        $withdraw->update($data);
        $message="Dear Merchant, Your withdrawal request from neoseller.com.bd has been rejected. Tk ".$withdraw->amount." has refund your main balance."; 
        $to=$account->phone;
        $get=SMS::sendSms(urlencode($message),$to);
        if ($get) {
   			$notification=array(
   			   'rmessage'=>'Successfully rejected',
   			   'alert-type'=>'success'
   			);
   			return back()->with($notification);  
        }
	
    }




        //*** GET Request	
        public function accept($id)
        {
            $withdraw = Withdraw::findOrFail($id);
            $data['status'] = "completed";
            $withdraw->update($data);
    	    //--- Redirect Section  
             $transnumber=mt_rand(1000000000, 9999999999);

    	    $trans=new Transaction;  

    	    $trans->transid  =$transnumber;
    	    $trans->amount   =$withdraw->amount;
    	    $trans->transtype=1;
    	    $trans->user_id  =$withdraw->user_id;
    	    $trans->save();

    	    $message="Dear Member, Your withdrawal request from neoseller.com.bd has been completed. Tk ".$withdraw->amount." has been ".$withdraw->method." Transaction ID ".$transnumber."."; 

    	    $user = DB::table('users')->where('id', $withdraw->user_id)->first();
    	    $to=$user->phone;
    	    $get=SMS::sendSms(urlencode($message),$to);
    	    if ($get) {
    	    	 $msg='Withdraw Accepted Successfully.';
    	    	 return response()->json($msg); 
    	    } 
    	    //--- Redirect Section Ends   
        }


	    //*** GET Request	
	    public function reject($id)
	    {
	        $withdraw = Withdraw::findOrFail($id);
	        $account = User::findOrFail($withdraw->user_id);

	        $account->incomebalance = $account->incomebalance + $withdraw->amount + $withdraw->fee;
	        $account->update();

	        $data['status'] = "rejected";
	        $withdraw->update($data);
	        $message="Dear Member, Your withdrawal request from neoseller.com.bd has been rejected. Tk ".$withdraw->amount." has refund your main balance."; 
	        $to=$account->phone;
	        $get=SMS::sendSms(urlencode($message),$to);
	        if ($get) {
	        	 
		       $msg = 'Withdraw Rejected Successfully.';
		  

		    return response()->json($msg);      
		   
	        }
		
	    }


	    public function detuch(Request $request){
	    	$user=User::findOrFail($request->userid);

	    	$current_balance    =$user->incomebalance;
	    	$current_balance    =$current_balance-$request->amount;
	    	$user->incomebalance=$current_balance;
	    	$user->save();
		    $message="Dear ".$user->name.", as order ".$request->orderid." has been return so taka ".$request->amount." is detuched from your balance as delivery charge. Thank you."; 
		    $to=$user->phone;
		     $get=SMS::sendSms(urlencode($message),$to);
		     if ($get) {
					$notification=array(
					   'rmessage'=>'Successfully detuched',
					   'alert-type'=>'success'
					);
					return back()->with($notification);  
		     }
	    }
	    
	    
	     public function send_message(Request $request){
	    	$users=User::get();
	    	$message=$request->message;
	    	if (count($users)>0) {
	    		foreach ($users  as $user) {
	    			SMS::sendSms(urlencode($message),$user->phone);
		           
	    		}
	    	}

	       $notification=array(
			   'rmessage'=>'Messages successfully to all resellers',
			   'alert-type'=>'success'
			);
			return back()->with($notification);  
	    }
	    
	     public function single_message(Request $request){
	    	
	    	$message=$request->message;
	    	$user=User::findOrFail($request->user_id);
	    	
	    	 SMS::sendSms(urlencode($message),$user->phone);
		    
			$notification=array(
			   'rmessage'=>'Successfully message sent',
			   'alert-type'=>'success'
			);
			return back()->with($notification);  
		     
	    }

	    public function send_email(Request $request){
	    	
	    	
	    	
	    	$this->validate($request, [
	    	        'to'      => 'required|email',
	    	        'subject' => 'required',
	    	        'message' => 'required'
	    	    ]);

	    	$email  =$request->to;
	    	$subject=$request->subject;
	    	$message=$request->message;

	    	$user=User::where('email',$email)->get()->first();
	    	
	    	
	    	$data   =array(
	    		'email'  =>$email,
	    		'subject'=>$subject,
	    		'message'=>$message,
	    		'name'   => $user->name
	    		
	    	);

	    	Mail::send(new SellerMessege($email,$subject,$data));
	    	

	    	$notification=array(
	    	   'rmessage'=>'Successfully email sent',
	    	   'alert-type'=>'success'
	    	);
	    	return back()->with($notification); 

	    }

}