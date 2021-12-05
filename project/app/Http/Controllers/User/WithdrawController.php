<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\User;
use App\Models\Withdraw;
use Session;
use App\helpers\SMS;


class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

  	public function index()
    {
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')->user()->id)->where('type','=','user')->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('user.withdraw.index',compact('withdraws','sign'));
    }

   


    public function create()
    {
        $sign = Currency::where('is_default','=',1)->first();
        return view('user.withdraw.withdraw' ,compact('sign'));
    }


    public function store(Request $request)
    {

        $from = User::findOrFail(Auth::guard('web')->user()->id);

        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if($request->amount > 0){

            $amount = $request->amount;

            if ($from->affilate_income >= $amount){
                $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
                $finalamount = $amount - $fee;
                if ($from->affilate_income >= $finalamount){
                $finalamount = number_format((float)$finalamount,2,'.','');

                $from->affilate_income = $from->affilate_income - $amount;
                $from->update();

                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = Auth::guard('web')->user()->id;
                $newwithdraw['method'] = $request->methods;
                $newwithdraw['acc_email'] = $request->acc_email;
                $newwithdraw['iban'] = $request->iban;
                $newwithdraw['country'] = $request->acc_country;
                $newwithdraw['acc_name'] = $request->acc_name;
                $newwithdraw['address'] = $request->address;
                $newwithdraw['swift'] = $request->swift;
                $newwithdraw['reference'] = $request->reference;
                $newwithdraw['amount'] = $finalamount;
                $newwithdraw['fee'] = $fee;
                $newwithdraw['type'] = 'user';
                $newwithdraw->save();

                return response()->json('Withdraw Request Sent Successfully.'); 
            }else{
                return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 

            }
            }else{
                return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 

            }
        }
            return response()->json(array('errors' => [ 0 => 'Please enter a valid amount.' ])); 

    }

    public function withdraw(Request $request){

       // echo "ok";
       // exit;

        $user = User::findOrFail(Auth::guard('web')->user()->id);

        if ($request->amount > $user->incomebalance) {
            Session::flash('errormessage', 'Invalid amount');
            return back();
        }else{
            $newwithdraw = new Withdraw();
            $newwithdraw['user_id'] = Auth::guard('web')->user()->id;
            $newwithdraw['method'] = $request->pmethod;
            $newwithdraw['amount'] = $request->amount;
            $newwithdraw['type'] = 'user';
            if ($request->pmethod=='bkash') {
                 $newwithdraw['number'] = $request->phone; 
            }else{
                if ($request->amount<1000) {
                    Session::flash('errormessage', 'You have to minimum 1000 Tk for banking method');
                    return back();
                }else{

                 $newwithdraw['bname'] = $request->bname;
                 $newwithdraw['branchname'] = $request->branchname;
                 $newwithdraw['ahname'] = $request->ahname;
                 $newwithdraw['accountno'] = $request->accountno; 
             }
            }
            $user->incomebalance -=$request->amount;
            $user->save();
            $newwithdraw->save();

               $message="Dear Member, Your request for TK ".$request->amount." withdrawal from newseller.com.bd has been placed successfully. It'll be proccessed within 24 hours.";

            //===sms code here====
             $to=$user->phone;
             $get=SMS::sendSms(urlencode($message),$to);
             if ($get) {
                 Session::flash('rmessage', 'Your transaction is being proccessing.');
                 return redirect('user/affiliate-all-balance');
             }else{
                Session::flash('errormessage', 'Something went wrong.');
                return redirect('user/affiliate-all-balance');
             }

            
        }


    }
}
