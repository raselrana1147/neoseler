<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;
use DB;
use Carbon\Carbon;
use App\Models\Admin;
use App\helpers\SMS;
use App\Models\Apply;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('superadmin',['only'=>['dailyreport','weeklyreport','monthlyreport',
            'customreport','generate_bkup','showForm','show']]);

    }

   

    public function index()
    {
        $pending = Order::where('status','=','pending')->get();
        $processing = Order::where('status','=','processing')->get();
        $completed = Order::where('status','=','completed')->get();
        $days = "";
        $sales = "";

        $month="";
        $monthsale="";

        for($i = 0; $i < 30; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }

        
        $owner=Auth::guard('admin')->user()->username;
        //$usersAndLogactivity = \App\User::whereNotIn('id', [1])->with(['logs', function($q){
            //for ($i=1; $i<=12; $i++){
               // $q->whereMonth('created_at', date('m',strtotime('-'.$i.' month')))->count();
            //}
       // }])->get();

        $users = User::all();
        $products = Product::all();
        $blogs = Blog::all();
        $pproducts = Product::where('pro_owner',$owner)->orderBy('id','desc')->take(5)->get();
        $rorders = Order::orderBy('id','desc')->take(5)->get();
        $poproducts = Product::where('pro_owner',$owner)->orderBy('views','desc')->take(5)->get();
        $rusers = User::orderBy('id','desc')->take(5)->get();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $activation_notify = "";
        if (file_exists(public_path().'/rooted.txt')){
            $rooted = file_get_contents(public_path().'/rooted.txt');
            if ($rooted < date('Y-m-d', strtotime("+10 days"))){
                $activation_notify = "<i class='icofont-warning-alt icofont-4x'></i><br>Please activate your system.<br> If you do not activate your system now, it will be inactive on ".$rooted."!!<br><a href='".url('/admin/activation')."' class='btn btn-success'>Activate Now</a>";
            }
        }


        return view('admin.dashboard',compact('pending','activation_notify','processing','completed','products','users','blogs','days','sales','pproducts','rorders','poproducts','rusers','referrals','browsers'));
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();  
        return view('admin.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'avatar' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ];


        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();  
        $data = Auth::guard('admin')->user();        
            if ($file = $request->file('avatar')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/admins/',$name);
                if($data->avatar != null)
                {
                    if (file_exists(public_path().'/assets/images/admins/'.$data->avatar)) {
                        unlink(public_path().'/assets/images/admins/'.$data->avatar);
                    }
                }            
            $input['avatar'] = $name;
            } 
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg); 
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();  
        return view('admin.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));     
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));   
            }
        }
        $admin->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }



    public function generate_bkup()
    {
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            $bkuplink = url($chk);
        }
        return view('admin.movetoserver',compact('bkuplink','chk'));
    }


    public function clear_bkup()
    {
        $destination  = public_path().'/install';
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        $handle = fopen('backup.txt','w+');
        fwrite($handle,"");
        fclose($handle);
        //return "No Backup File Generated.";
        return redirect()->back()->with('success','Backup file Deleted Successfully!');
    }


    public function activation()
    {
        $activation_data = "";
        if (file_exists(public_path().'/project/license.txt')){
            $license = file_get_contents(public_path().'/project/license.txt');
            if ($license != ""){
                $activation_data = "<i style='color:darkgreen;' class='icofont-check-circled icofont-4x'></i><br><h3 style='color:darkgreen;'>Your System is Activated!</h3><br> Your License Key:  <b>".$license."</b>";
            }
        }
        return view('admin.activation',compact('activation_data'));
    }


    public function activation_submit(Request $request)
    {
        //return config('services.genius.ocean');
        $purchase_code =  $request->pcode;
        $my_script =  'eCommerce';
        $my_domain = url('/');

        $varUrl = str_replace (' ', '%20', config('services.genius.ocean').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

        if( ini_get('allow_url_fopen') ) {
            $contents = file_get_contents($varUrl);
        }else{
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $varUrl);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
        }

        $chk = json_decode($contents,true);

        if($chk['status'] != "success")
        {

            $msg = $chk['message'];
            return response()->json($msg);
            //return redirect()->back()->with('unsuccess',$chk['message']);

        }else{
            $this->setUp($chk['p2'],$chk['lData']);

            if (file_exists(public_path().'/rooted.txt')){
                unlink(public_path().'/rooted.txt');
            }

           $fpbt = fopen(public_path().'/project/license.txt', 'w');
           fwrite($fpbt, $purchase_code);
           fclose($fpbt);

            $msg = 'Congratulation!! Your System is successfully Activated.';
            return response()->json($msg);
            //return redirect('admin/dashboard')->with('success','Congratulation!! Your System is successfully Activated.');
        }
        //return config('services.genius.ocean');
    }

    

    function setUp($mtFile,$goFileData){
        $fpa = fopen(public_path().$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }



    public function movescript(){
        ini_set('max_execution_time', 3000);

        $destination  = public_path().'/install';
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }

        $src = base_path().'/vendor/update';
        $this->recurse_copy($src,$destination);
        $files = public_path();
        $bkupname = 'GeniusCart-By-GeniusOcean-'.date('Y-m-d').'.zip';

        $zipper = new \Chumper\Zipper\Zipper;

        $zipper->make($bkupname)->add($files);

        $zipper->remove($bkupname);

        $zipper->close();

        $handle = fopen('backup.txt','w+');
        fwrite($handle,$bkupname);
        fclose($handle);

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        return response()->json(['status' => 'success','backupfile' => url($bkupname),'filename' => $bkupname],200);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }


    public function dailyreport(){

        //$orders=DB::table("orders")
             //->select("*" ,DB::raw("(COUNT(*)) as totalorder, sum(pay_amount) as price, sum(totalQty) as totalqun"))
             //->groupBy(DB::raw("day(created_at)"))
             //->get();
        //$orders=DB::table('orders')->get();

        $dateS = new Carbon();

        $start=$dateS->format('Y-m-d')." 00:00:01";
        $to=$dateS->format('Y-m-d')." 23:59:59";
    
        $orders = Order::whereBetween('created_at', [$start,$to])->get();

        $totaltk = DB::table('orders')
        ->whereBetween('created_at', [$start,$to])->get()->sum('pay_amount');

            $totalqun = DB::table('orders')->whereBetween('created_at', [$start,$to])
            ->get()->sum('totalQty');

            $discount= DB::table('orders')->whereBetween('created_at', [$start,$to])
            ->get()->sum('coupon_discount');

             $shipcost= DB::table('orders')->whereBetween('created_at', [$start,$to])
            ->get()->sum('shipping_cost');
        
         $totalorder = DB::table('orders')
        ->whereBetween('created_at', [$start,$to])->count();

            $grandtotal=$totaltk+$discount+$shipcost; 

        return view('admin.reports.daily',compact('orders','totaltk','totalqun','totalorder','grandtotal'));
    }


    public function weeklyreport(){

        $dateS =Carbon::today();
       
        $start=$dateS->format('Y-m-d')." 23:59:59";
        $to=$dateS->subDays(7)->format('Y-m-d')." 00:00:01";
        $orders = Order::whereBetween('created_at', [$to,$start])->get();
        $totaltk = DB::table('orders')
        ->whereBetween('created_at', [$to,$start])->get()->sum('pay_amount');

        $discount= DB::table('orders')->whereBetween('created_at', [$start,$to])
        ->get()->sum('coupon_discount');
         $shipcost= DB::table('orders')->whereBetween('created_at', [$start,$to])
        ->get()->sum('shipping_cost');
        $totalqun = DB::table('orders')
       ->whereBetween('created_at', [$to,$start])->get()->sum('totalQty')
        ;
         $totalorder = DB::table('orders')
        ->whereBetween('created_at', [$to,$start])->count();
        
         $grandtotal=$totaltk+$discount+$shipcost;
        return view('admin.reports.weekly',compact('orders','totaltk','totalqun','totalorder','grandtotal'));
    }


    public function monthlyreport(){

        $dateS =Carbon::today();
       
        $start=$dateS->format('Y-m-d')." 23:59:59";
        $to=$dateS->subDays(30)->format('Y-m-d')." 00:00:01";



        
        $orders = Order::whereBetween('created_at', [$to,$start])->get();


        $totaltk = DB::table('orders')
        ->whereBetween('created_at', [$to,$start])->get()->sum('pay_amount');

        $totalqun = DB::table('orders')
       ->whereBetween('created_at', [$to,$start])->get()->sum('totalQty')
        ;

        $discount= DB::table('orders')->whereBetween('created_at', [$start,$to])
        ->get()->sum('coupon_discount');
         $shipcost= DB::table('orders')->whereBetween('created_at', [$start,$to])
        ->get()->sum('shipping_cost');

         $totalorder = DB::table('orders')
        ->whereBetween('created_at', [$to,$start])->count();
        
          $grandtotal=$totaltk+$discount+$shipcost;
        return view('admin.reports.weekly',compact('orders','totaltk','totalqun','totalorder','grandtotal'));
    }


    public function customreport(Request $request){

         //$dateS =Carbon::today();
        
         $start=$request->rrstartdate." 23:59:59";
         $to=$request->rrenddate." 00:00:01";
       //  return $to;

         $rrstartdate=$request->rrstartdate;
         $rrenddate=$request->rrenddate;
           

         
         $orders = Order::whereBetween('created_at', [$to,$start])->get();


         $totaltk = DB::table('orders')
         ->whereBetween('created_at', [$to,$start])->get()->sum('pay_amount');

         $totalqun = DB::table('orders')
        ->whereBetween('created_at', [$to,$start])->get()->sum('totalQty')
         ;
        $discount= DB::table('orders')->whereBetween('created_at', [$start,$to])
         ->get()->sum('coupon_discount');
          $shipcost= DB::table('orders')->whereBetween('created_at', [$start,$to])
         ->get()->sum('shipping_cost');
         $grandtotal=$totaltk+$discount+$shipcost;
          $totalorder = DB::table('orders')
         ->whereBetween('created_at', [$to,$start])->count();
         return view('admin.reports.custom',compact('orders','totaltk','totalqun','totalorder','rrstartdate','rrenddate','grandtotal'));
    }

    public function showForm($id){
        $applicant=Apply::find($id);
        return view('admin.merchant.create',compact('applicant'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'email'=>'unique:admins,email',
            'phone'=>'unique:admins,phone',
            'username'=>'unique:admins,username',
        ]);
        $admin            =new Admin;
        $admin->name      =$request->name;
        $admin->email     =$request->email;
        $admin->phone     =$request->phone;
        $admin->commission=$request->commission;
        $admin->username  ="merchant".rand(10000,99999);;
        $admin->password  =Hash::make($request->password);
        $admin->role      ="Merchant";
        $admin->save();

         $message="Hello ".$admin->name.",your merchant account has been created. Please start your bussiness very soon. Your email:".$admin->email." Password: ".$request->password." Please sing in";
         $to=$admin->phone;

         $get=SMS::sendSms(urlencode($message),$to);
         if ($get) {
             $notification=array(
                        'rmessage'=>'Merchant is created successfully',
                        'alert-type'=>'success'
                         );
                  return redirect(route('merchant.show'))->with($notification);
         }else{
            $notification=array(
                   'rmessage'=>'Not created',
                   'alert-type'=>'error'
                    );
              return redirect(route('merchant.show'))->with($notification);
         }
    }

    public function show(){
        $merchants=Admin::all();
        return view("admin.merchant.index",compact('merchants'));
    }

 public function reject($id){
        $applicant=Apply::findOrFail($id);

        $message="Hello ".$applicant->name.",your merchant application has been rejected due to some issues. Please contact with admin.";
        $to=$applicant->phone;

        $get=SMS::sendSms(urlencode($message),$to);
        if ($get) {
            $applicant->status=3;
            $applicant->save();
            $notification=array(
                       'rmessage'=>'Merchant is rejected successfully',
                       'alert-type'=>'success'
                        );
                 return back()->with($notification);
        }else{
           $notification=array(
                  'rmessage'=>'Not rejected',
                  'alert-type'=>'error'
                   );
             return redirect(route('merchant.show'))->with($notification);
        }


    }

}