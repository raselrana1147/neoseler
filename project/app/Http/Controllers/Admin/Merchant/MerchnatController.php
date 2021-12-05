<?php

namespace App\Http\Controllers\Admin\Merchant;
use App\Models\Childcategory;
use App\Models\Subcategory;
use Datatables;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Image;
use Auth;
use App\Models\Order;
use App\Models\Account;
use App\Models\Admin;
use DB;
use App\Models\Withdraw;
use App\helpers\SMS; 
use App\Models\Apply;

class MerchnatController extends Controller
{
    public function __construct()
     {
        $this->middleware('auth:admin');
        $this->middleware('merchant',['only'=>['sale_history','sale_history_pending','sale_history_completed','commission_history','account','myWithdraw']]);
        $this->middleware('superadmin',['only'=>['sell_history','total_commission','allWithdraw','apliedMerchant']]);
     }


     public function datatables(){
     	$datas=Apply::where('status','=','1')->get();
     	return Datatables::of($datas)

     	                   ->editColumn('name', function(Apply $data) {
     	                       return $data->name;
     	                   })
     	                   ->editColumn('phone',function(Apply $data){
     	                   		return $data->phone;
     	                   })
     	                    ->editColumn('email',function(Apply $data){
     	                   		return $data->email;
     	                   })
     	                    ->editColumn('businessname',function(Apply $data){
     	                   		return $data->businessname;
     	                   })
     	                   ->addColumn('action', function(Apply $data) {
     	                       return '<div class="action-list"><a href="'.route('merchant.create',$data->id).'">Create</a> <a href="'.route('merchant.application.reject',$data->id).'" class="delivery">Reject</a></div>';   
     	                   })
     	                   ->rawColumns(['action'])
     	                   ->toJson(); 

     }
     
      public function reject_datatable(){
     	$datas=Apply::where('status','=','3')->get();
     	return Datatables::of($datas)

     	                   ->editColumn('name', function(Apply $data) {
     	                       return $data->name;
     	                   })
     	                   ->editColumn('phone',function(Apply $data){
     	                   		return $data->phone;
     	                   })
     	                    ->editColumn('email',function(Apply $data){
     	                   		return $data->email;
     	                   })
     	                    ->editColumn('businessname',function(Apply $data){
     	                   		return $data->businessname;
     	                   })
     	                   ->addColumn('action', function(Apply $data) {
     	                       return '<div class="action-list"><a href="'.route('merchant.create',$data->id).'">Create</a></div>';   
     	                   })
     	                   ->rawColumns(['action'])
     	                   ->toJson(); 
     }


     public function apliedMerchant(){
     	return view('admin.merchant.merchant.apply');
     }
     
      public function reject_marchant(){
     	return view('admin.merchant.merchant.reject');
     }
     
     public function sale_history_pending()
	{
		$orders=Order::where('status','=','pending')->orderBy('id','DESC')->get();

		return view('admin.merchant.merchant.sale_history_pending',compact('orders'));
	}

	public function sale_history_completed()
	{
		$orders=Order::where('status','=','completed')->orderBy('id','DESC')->get();

		return view('admin.merchant.merchant.sale_history_completed',compact('orders'));
	}
	

	public function sale_history()
	{
		$orders=Order::orderBy('id','DESC')->get();

		return view('admin.merchant.merchant.sale_history',compact('orders'));
	}
	
	public function pending_order(){

		$orders=Order::where('status','pending')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.pending_order',compact('orders'));
	}

	public function processing_order(){

		$orders=Order::where('status','processing')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.processing_order',compact('orders'));
	}

	public function completed_order(){

		$orders=Order::where('status','completed')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.completed_order',compact('orders'));
	}

	public function ondelivery_order(){

		$orders=Order::where('status','on delivery')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.ondelivery_order',compact('orders'));
	}

	public function returned_order(){

		$orders=Order::where('status','returned')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.returned_order',compact('orders'));
	}

	public function declined_order(){

		$orders=Order::where('status','declined')->orderBy('id','DESC')->get();
		return view('admin.merchant.merchant.declined_order',compact('orders'));
	}

	public function commission_history(){

		$admin=Auth::guard('admin')->user()->id;
		$accounts = Account::where([
		    'merchant_user' => $admin,])
		    ->groupBy('order_id')
		    ->selectRaw('accounts.*, sum(amount) as total_amount, sum(commission) as total_commission, order_id')
		    ->get();
		 
		return view('admin.merchant.merchant.commission_history',compact('accounts'));
	}

	public function addToAccount($id)
	{		
			$merchant_id=Auth::guard('admin')->user()->id;
			$accounts=Account::where(['order_id'=>$id,'merchant_user'=>$merchant_id])->get();
			$total=0;
			foreach ($accounts as $key => $account) {
				$total+=$account->amount;
				Account::where(['order_id'=>$account->order_id,'merchant_user'=>$account->merchant_user])
				->update(['collect_amount' => '2']);
			}
			
			$admin      =Admin::find($merchant_id);
			$new_balance=$admin->balance;
			$new_total  =$admin->total_sell;
			$new_balance=$new_balance+$total;
			$new_total  =$new_total+$total;

			$admin->balance   =$new_balance;
			$admin->total_sell=$new_total;

			$admin->save();

			$notification=array(
			           'rmessage'=>'Successfullya added in main balance',
			           'alert-type'=>'success'
			            );
			     return back()->with($notification);
			
	}

	public function account()
	{
	    
		$username=Auth::guard('admin')->user()->username;
		$orders=Order::where('status','!=','completed')
        ->where('status','!=','declined')
        ->where('status','!=','returned')->get();
        
		$pending_balance=0;

		foreach ($orders as $order) {
			 $cart=unserialize($order->cart);
			 foreach ($cart->items as $product) {
			 	$owner=Product::find($product['item']['id'])->pro_owner;
			 	$pro=Product::find($product['item']['id']);
			 	if ($username==$owner) {
			 		$pending_balance+=$pro->price*$product['qty'];
			 	}
			 }
		}

		$admin=Admin::find(Auth::guard('admin')->user()->id);
		return view('admin.merchant.merchant.account',compact('admin','pending_balance'));
	}


	public function withdraw(Request $request){

		
		$admin= Admin::findOrFail(Auth::guard('admin')->user()->id);

		if ($request->amount > $admin->balance) {
		  $notification=array(
		             'rmessage'=>'Invalid Amount',
		             'alert-type'=>'error'
		              );
		       return back()->with($notification);
		}else{
		    $newwithdraw = new Withdraw();
		    $newwithdraw['user_id'] = $admin->id;
		    $newwithdraw['method'] = $request->pmethod;
		    $newwithdraw['amount'] = $request->amount;
		    $newwithdraw['type'] = 'merchant';
		    if ($request->pmethod=='bkash') {
		         $newwithdraw['number'] = $request->phone; 
		    }else{
		        if ($request->amount<1000) {
		           $notification=array(
		                      'rmessage'=>'Amount should be greater than 1000 Taka.',
		                      'alert-type'=>'error'
		                       );
		            return redirect(route('admin.merchant.account'))->with($notification);
		        }else{

		         $newwithdraw['bname'] = $request->bname;
		         $newwithdraw['branchname'] = $request->branchname;
		         $newwithdraw['ahname'] = $request->ahname;
		         $newwithdraw['accountno'] = $request->accountno; 
		     }
		    }
		    $admin->balance -=$request->amount;
		    $admin->save();
		    $newwithdraw->save();

		       $message="Dear Merchant, Your are going to withdraw TK ".$request->amount." from your main balance. newseller.com.bd. It'll be proccessed within 24 hours.";

		    //===sms code here====
		     $to=$admin->phone;
		     $get=SMS::sendSms(urlencode($message),$to);
		     if ($get) {
		       $notification=array(
		                  'rmessage'=>'Successfully placed your request.',
		                  'alert-type'=>'success'
		                   );
		        return back()->with($notification);
		     }else{
		        $notification=array(
		                   'rmessage'=>'Something went wrong.',
		                   'alert-type'=>'error'
		                    );
		         return back()->with($notification);
		     }

		}

	}

	public function myWithdraw(){
		$withdraws=Withdraw::where('user_id',Auth::guard('admin')->user()->id)->get();
		return view('admin.merchant.merchant.withdraw',compact('withdraws'));
	}



	
}
