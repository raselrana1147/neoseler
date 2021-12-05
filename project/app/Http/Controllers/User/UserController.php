<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use App\Models\Generalsetting;
use App\Models\UserSubscription;
use App\AffiliateM;
use App\helpers\SMS;
use App\Models\Product;
use Session;
use App\Aorder;
use App\Models\User;
use DB;
use App\Transaction;
use App\Promotional;
use App\Models\Withdraw;
use App\Models\MyShop;
use App\Models\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();  
        return view('user.dashboard',compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();  
        return view('user.profile',compact('user'));
    }

   

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'phone' => 'unique:users,phone,'.Auth::user()->id
        ];


        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();  
        $data = Auth::user();        
            if ($file = $request->file('photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/users/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/users/'.$data->photo)) {
                        unlink(public_path().'/assets/images/users/'.$data->photo);
                    }
                }            
            $input['photo'] = $name;
            } 
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg); 
    }

    public function shopupdate(Request $request)
    {
        //--- Validation Section
        $input = $request->all();  
        $data = Auth::user();        
        $data->update($input);
        $msg = 'Successfully updated your shop';
        return response()->json($msg); 
    }


    public function resetform()
    {
        return view('user.reset');
    }

    public function reset(Request $request)
    {
        $user = Auth::user();
        
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));     
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));   
            }
        }
        $user->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }


    public function package()
    {
        $user = Auth::user();
        $subs = Subscription::all();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        return view('user.package.index',compact('user','subs','package'));
    }


    public function vendorrequest($id)
    {
        $subs = Subscription::findOrFail($id);
        $gs = Generalsetting::findOrfail(1);
        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        if($gs->reg_vendor != 1)
        {
            return redirect()->back();
        }
        return view('user.package.details',compact('user','subs','package'));
    }

    public function vendorrequestsub(Request $request)
    {
        $this->validate($request, [
            'shop_name'   => 'unique:users',
           ],[ 
               'shop_name.unique' => 'This shop name has already been taken.'
            ]);
        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($request->subs_id);
        $settings = Generalsetting::findOrFail(1);
                    $today = Carbon::now()->format('Y-m-d');
                    $input = $request->all();  
                    $user->is_vendor = 2;
                    $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
                    $user->mail_sent = 1;     
                    $user->update($input);
                    $sub = new UserSubscription;
                    $sub->user_id = $user->id;
                    $sub->subscription_id = $subs->id;
                    $sub->title = $subs->title;
                    $sub->currency = $subs->currency;
                    $sub->currency_code = $subs->currency_code;
                    $sub->price = $subs->price;
                    $sub->days = $subs->days;
                    $sub->allowed_products = $subs->allowed_products;
                    $sub->details = $subs->details;
                    $sub->method = 'Free';
                    $sub->status = 1;
                    $sub->save();
                    if($settings->is_smtp == 1)
                    {
                    $data = [
                        'to' => $user->email,
                        'type' => "vendor_accept",
                        'cname' => $user->name,
                        'oamount' => "",
                        'aname' => "",
                        'aemail' => "",
                        'onumber' => "",
                    ];    
                    $mailer = new GeniusMailer();
                    $mailer->sendAutoMail($data);        
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Your Vendor Account Activated','Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.',$headers);
                    }

                    return redirect()->route('user-dashboard')->with('success','Vendor Account Activated Successfully');

    }


    public function affilateform(){
        return view('user.affiliate.applyform');
    }

    public function storeaffiliates(Request $request){
       $this->validate($request,[
            'username'=>'required|unique:affiliate_ms,username',
            'fbprofile'=>'required',
            'sellmethod'=>'required',
            'usertype'=>'required',
            'user_id'=>'required'
       ]);

       $amember=new AffiliateM();

       $amember->username=$request->username;
       $amember->fbprofile=$request->fbprofile;
       $amember->sellmethod=$request->sellmethod;
       $amember->usertype=$request->usertype;
       $amember->user_id=$request->user_id;

       if ($request->usertype=="yes") {
            $amember->shopname=$request->shopname;
            $amember->location=$request->location;
            $amember->businesstype=$request->businesstype;
       }

       $amember->save();

       $facebook_page="fb.me/afnep";

       $message="Dear member, Thanks for your interest to work with ".$facebook_page." Our team will review your information in shortly. Please wait for your confimation";

       $to=Auth::user()->phone;
       $get=SMS::sendSms(urlencode($message),$to);

       if ($get) {
            return back()->with('rmessage','Your application has been send successfully. As soon as possible we will contact with you. Thank you.');
       }else{
           Session::flash('errormessage', 'Something wents wrong. Please try again');
          return back();
       }

        //return back()->with('rmessage','');




    }

    public function allproduct(){
        $datas = Product::where('product_type','=','normal')->orderBy('id','desc')->get();
        return view('user.products.allproduct',compact('datas'));
    }

//====afiliate order now=============
    public function affilateoder(Request $request){

       

        //$prom=Promotional::all();
        $prom = Promotional::findOrFail(1);

        $productid=$request->productid;
        $p        =Product::where('id',$productid)->first();
        $price    =$p->price;
        $user     =Auth::user()->id;
        $affusername =AffiliateM::where('user_id',$user)->first();

        $username =$affusername->username;

        // first 3 sell withing 7 days===

        $fu=AffiliateM::where('username',$username)->first();
        $today= strtotime(date("Y-m-d"));
        $memberfrom= date('Y-m-d',strtotime($fu->updated_at));
        $days=($today-strtotime($memberfrom))/(60*60*24);
        $user1=Auth::user();
         if ($days <8  ) {
            if ($user1->sellbonus==0) {
                $ordercount=Aorder::where('username',$username)->get()->count();
                if ($ordercount > 2) {
                    $user1->incomebalance +=$prom->seven_days;
                    $user1->sellbonus=1;
                    $user1->save();

                    $transaction=new Transaction();
                    $transaction->transid="#".rand(1000,99999);
                    $transaction->amount=100;
                    $transaction->transtype=1;
                    $transaction->user_id=$user1->id;
                    $transaction->save();
                    
                }
            }
         }

     // parant bonus count
         $countorder=Aorder::where('username',$username)->get()->count();

         if ($countorder >= 2) {
             $userstatus=AffiliateM::where('username',$username)->first();
             if (!is_null($userstatus)) {
                 $parentuser=AffiliateM::where('username',$userstatus->ref_username)->first();
                 if (!is_null($parentuser)) {
                     $parentu=User::where('id',$parentuser->user_id)->first();
                     if ($userstatus->parentbonus==0) {
                         $parentu->incomebalance +=$prom->sponser_gat;
                         $userstatus->parentbonus=1;
                         $parentu->save();
                         $userstatus->save();

                         $transaction=new Transaction();
                         $transaction->transid="#".rand(1000,99999);
                         $transaction->amount=100;
                         $transaction->transtype=1;
                         $transaction->user_id=$parentu->id;
                         $transaction->save();
                     }
                 }
             }
         }
         
         // end parant

         // having 15 sell commision

         $countsellAorder= DB::table('aorders')
                          ->where('username',$username)
                          ->whereMonth('created_at', Carbon::now()->month)
                          ->count();

         $countsellorder= DB::table('orders')
                         ->where('affilate_user',$username)
                         ->whereMonth('created_at', Carbon::now()->month)
                         ->count();

         $totalsell=$countsellAorder+$countsellorder;

         if ($totalsell == 15) {
             $userprofile=User::where('id',$affusername->user_id)->first();
             if (!is_null($userprofile)) {
                 $userprofile->incomebalance +=$prom->fifteen_sell;
                 $userprofile->save();

                 $transaction=new Transaction();
                 $transaction->transid="#".rand(1000,99999);
                 $transaction->amount=$prom->fifteen_sell;
                 $transaction->transtype=1;
                 $transaction->user_id=$affusername->user_id;
                 $transaction->save();

                 $facebook_page="fb.me/afnep";
                 $message3="Congratulations! You have received TK ".$prom->fifteen_sell.". for 15 sells in this months. Check your account for more info ".$facebook_page;
                 
                 $get=SMS::sendSms(urlencode($message3),$userprofile->phone);
             }
         }

         // end 15 sell per month==

        if ($request->price < $price) {
             Session::flash('errormessage', 'Your product price has to be greater than or equal <b>'.$price."</b> TK");
               return back();
        }else{

             $extratk  =$request->price-$price;
             
             $commision=$extratk+($price*10)/100;
             $orderid="#".rand(1000,99999);

             if ($p->special_com !=null) {
                 $totalcom=($commision*$request->quantity)+$p->special_com;
             }else{
                $totalcom=($commision*$request->quantity);
             }

             //$totalcom=$commision*$request->quantity;

             $ao=new Aorder();

             $ao->customer_name   =$request->customer_name;
             $ao->customer_phone  =$request->customer_phone;
             $ao->customer_city   =$request->customer_city;
             $ao->customer_address=$request->customer_address;
             $ao->price           =$request->price;
             $ao->rootprice       =$price;
             $ao->quantity        =$request->quantity;
             $ao->username        =$username;
             $ao->commission      =$totalcom;
             $ao->order_number    =$orderid;
             $ao->specialcom      =$p->special_com;
             $ao->shippingmethod  ="Cash on delivery";
             //$ao->order_stutus    ="pending";
             //$ao->pay_status      ="unpaid";
             $ao->shipping_cost   =$request->shipping;
             $ao->product_id      =$request->productid;
             $ao->save();


              $facebook_page="fb.me/afnep";
             $message="Congratulations! You have successfully placed your order from ".$facebook_page." Your order id is : ".$orderid." Soon we'll contact for confirming your order.";
             $message2="Congratulations! You have a new sale. You receive TK ".$commision.". It will be available as sson as we received the payment. Check your account for more info".$facebook_page;

            

             

             $to=$request->customer_phone;
             $userphone =Auth::user()->phone;

            
                $sms=[
                    array('msg'=>$message,'phone'=>$to),
                    array('msg'=>$message2,'phone'=>$userphone),
                    
                ];

                foreach ($sms as $data) {
                    $get=SMS::sendSms(urlencode($data['msg']),$data['phone']);
                }
               
             if ($get) {
            
             return back()->with('rmessage','Order has been placed successfully');

             }else{
                
                 return back()->with('errormessage','Something went wrong');

             }
            
        } 




    }



    public function affbalance()
    {
         $user=Auth::user();
        $income_balance=$user->incomebalance;
         $pending_balance=Order::where('status','!=','completed')
        ->where('status','!=','declined')
        ->where('status','!=','returned')
        ->where('affilate_user',$user->ref_user)->sum('affilate_charge');
        return view('user.affiliate.balance',compact('income_balance','pending_balance'));
    }

    public function salsehistory(){

        $am=AffiliateM::where('user_id',Auth::user()->id)->first();
        if (!is_null($am)) {

             $aorder=Aorder::where('username',$am->username)->get();

             return view('user.sales.sales',compact('aorder'));
        }
       

    }


    public function salescount(Request $request){
        $am=AffiliateM::where('user_id',Auth::user()->id)->first();

       

       
           if ($request->salessort=="daily") {
              $aorder=DB::table("aorders")
                   ->select("*" ,DB::raw("(COUNT(*)) as total"))
                   ->where('username', $am->username)  
                   ->orderBy('created_at')
                   ->groupBy(DB::raw("day(created_at)"))
                   ->get();

           }elseif($request->salessort=="monthly"){
               $aorder=DB::table("aorders")
                    ->select("*" ,DB::raw("(COUNT(*)) as total"))
                    ->where('username', $am->username)  
                    ->orderBy('created_at')
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->get();
           }elseif($request->salessort="weekly"){
                 $aorder=DB::table("aorders")
                    ->select("*" ,DB::raw("(COUNT(*)) as total"))
                    ->where('username', $am->username)  
                    ->orderBy('created_at')
                    ->groupBy(DB::raw("week(created_at)"))
                    ->get();
           }else{
               $aorder = DB::table('aorders')
                   ->select('*', DB::raw('count(*) as views'))
                   ->groupBy('created_at')
                   ->get();
           }
              

        return view('user.sales.count',compact('aorder'));
    }


    public function specialpro(){

        $datas=Product::where('special_com','!=','NULL')->get();

        
        return view('user.special.specialpro',compact('datas'));
    }

    public function detailcom($id){
        $product=Product::find($id);
        return view('user.special.detailcom',compact('product'));

    }


    public function withdraw_history()
    {
        $withdraws=Withdraw::where('user_id',Auth::guard('web')->user()->id)->get();
        return view('user.withdraw.index',compact('withdraws'));
    }


    public function myShop(){

       $myshops=MyShop::where('user_id',Auth::guard('web')->user()->id)->get();
       return view('user.myshop.index',compact('myshops'));
    }
    
     public function delete_myshop($id){

        $item=MyShop::findOrfail($id);
        $item->delete();

        Session::flash('rmessage', 'Product is successfully deleted from my shop');
        return back();

    }

    

    

}

