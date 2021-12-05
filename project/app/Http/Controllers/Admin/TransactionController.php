<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use Datatables;
use Auth;

class TransactionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
      
        $admin_id=Auth::guard('admin')->user()->id;
        if (Auth::guard('admin')->user()->IsMerchant()) {
            $datas=Transaction::where('user_id',$admin_id)->orderBy('id','DESC')->get();
        }else{
            $datas=Transaction::orderBy('id','DESC')->get();
        }
    
    	return Datatables::of($datas)
    	->addColumn('type',function(Transaction $data){

    		return $data->transtype==1 ? 'Seller' :'Merchant';

    	})->make(true);

    }

    public function transaction(){

    	return view('admin.transaction.tran_all');
    }
}
