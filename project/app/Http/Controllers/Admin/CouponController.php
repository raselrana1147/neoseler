<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class CouponController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('superadmin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Coupon::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('type', function(Coupon $data) {
                                $type = $data->type == 0 ? "Discount By Percentage" : "Discount By Amount";
                                return $type;
                            })
                            ->editColumn('price', function(Coupon $data) {
                                $price = $data->type == 0 ? $data->price.'%' : $data->price.'$';
                                return $price;
                            })
                            ->addColumn('status', function(Coupon $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            }) 
                            ->addColumn('action', function(Coupon $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-coupon-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-coupon-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.coupon.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.coupon.create');
    }

    //*** POST Request
    // public function store(Request $request)
    // {
    //     //--- Validation Section
    //      //dd($request->all());
    //     $rules = ['code' => 'unique:coupons'];
    //     $customs = ['code.unique' => 'This code has already been taken.'];
    //     $validator = Validator::make(Input::all(), $rules, $customs);
        
    //     if ($validator->fails()) {
    //       return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
    //     }   
    //     //--- Validation Section Ends

    //     //--- Logic Section
    //     $data = new Coupon();
    //     $input = $request->all();

    //     $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
    //     $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
    //     //$data->minamount=$input['minamount'];
    //     $data->fill($input)->save();
    //     //--- Logic Section Ends

    //     //--- Redirect Section        
    //     $msg = 'New Data Added Successfully.';
    //     return response()->json($msg);  

    //     //--- Redirect Section Ends   
    // }

    public function store(Request $request){
            
         $this->validate($request,[
            'code'=>'required|unique:coupons,code',
            'type'=>'required',
            'price'=>'required',
            'minamount'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);

         $coupon=new Coupon();

         $coupon->code=$request->code;
         $coupon->type=$request->type;
         $coupon->price=$request->price;
         $coupon->minamount=$request->minamount;
         $coupon->times=$request->times;
         $coupon->start_date=Carbon::parse($request->start_date)->format('Y-m-d');
         $coupon->end_date=Carbon::parse($request->start_date)->format('Y-m-d');


         $coupon->save();

            $notification=array(
                   'rmessage'=>'Coupon succcessfully done',
                   'alert-type'=>'success'
                    );
                 return Redirect()->to('admin/coupon')->with($notification);
            // $msg = 'Status Updated Successfully.';
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Coupon::findOrFail($id);
        return view('admin.coupon.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section

        $rules = ['code' => 'unique:coupons,code,'.$id];
        $customs = ['code.unique' => 'This code has already been taken.'];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }        
        //--- Validation Section Ends

        //--- Logic Section
        $data = Coupon::findOrFail($id);
        $input = $request->all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends           
    }
      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Coupon::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }


    
}
