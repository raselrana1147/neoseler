<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\PaymentGateway;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Admin;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use App\helpers\SMS;
use App\AffiliateM;
use App\Transaction;
use App\Aorder;
use App\Promotional;
use Carbon\Carbon;


class CheckoutController extends Controller
{
    public function loadpayment($slug1,$slug2)
    {
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $payment = $slug1;
        $pay_id = $slug2;
        $gateway = '';
        if($pay_id != 0) {
            $gateway = PaymentGateway::findOrFail($pay_id);
        }
        return view('load.payment',compact('payment','pay_id','gateway','curr'));
    }

    public function checkout()
    {

        $this->code_image();
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        
        $gs = Generalsetting::findOrFail(1);

        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

// If a user is Authenticated then there is no problm user can go for checkout

            //====affilate charge====
             $myoldCart = Session::get('cart');
            $mycart=new Cart($myoldCart);
            $maintotal = [];
             foreach($mycart->items as $pdata){
                $maintotal[] = ($pdata['item']['price']*$pdata['qty']);
             }

             $totalPrice=$mycart->totalPrice;
             $company_get= array_sum($maintotal);
             $affilate_charge=($totalPrice-$company_get);



        if(Auth::guard('web')->check())
        {
                $gateways =  PaymentGateway::where('status','=',1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method
                $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();

                // Packaging
                $package_data  = DB::table('packages')->where('user_id','=',0)->get();

                foreach ($products as $prod) {
                    if($prod['item']['type'] == 'Physical')
                    {
                        $dp = 0;
                        break;
                    }
                }

                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if($gs->tax != 0)
                {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if(!Session::has('coupon_total'))
                {
                $total = $total - $coupon;     
                $total = $total + 0;               
                }
                else {
                $total = Session::get('coupon_total');  
                $total = (int)$total + round(0 * $curr->value, 2); 
                }
                

                $user=Auth::user();
               


        return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr,'shipping_data' => $shipping_data,'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id,'acharge'=>$affilate_charge]);             
        }

        else

        {
// If guest checkout is activated then user can go for checkout
           	if($gs->guest_checkout == 1)
              {
                $gateways =  PaymentGateway::where('status','=',1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method
                $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();

                // Packaging
                $package_data  = DB::table('packages')->where('user_id','=',0)->get();

                foreach ($products as $prod) {
                    if($prod['item']['type'] == 'Physical')
                    {
                        $dp = 0;
                        break;
                    }
                }
                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if($gs->tax != 0)
                {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if(!Session::has('coupon_total'))
                {
                $total = $total - $coupon;     
                $total = $total + 0;               
                }
                else {
                $total = Session::get('coupon_total');  
                $total =  str_replace($curr->sign,'',$total) + round(0 * $curr->value, 2); 
                }
                foreach ($products as $prod) {
                    if($prod['item']['type'] != 'Physical')
                    {
                        if(!Auth::guard('web')->check())
                        {
                $ck = 1;

        return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr,'shipping_data' => $shipping_data,'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id,'acharge'=>$affilate_charge]);  
                        }
                    }
                }

        return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr,'shipping_data' => $shipping_data,'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id,'acharge'=>$affilate_charge]);                 
               }

// If guest checkout is Deactivated then display pop up form with proper error message

                    else{
                $gateways =  PaymentGateway::where('status','=',1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method
                $shipping_data  = DB::table('shippings')->where('user_id','=',0)->get();

                // Packaging
                $package_data  = DB::table('packages')->where('user_id','=',0)->get();



                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if($gs->tax != 0)
                {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if(!Session::has('coupon_total'))
                {
                $total = $total - $coupon;     
                $total = $total + 0;               
                }
                else {
                $total = Session::get('coupon_total');  
                $total = $total + round(0 * $curr->value, 2); 
                }
                $ck = 1;
       

        return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr,'shipping_data' => $shipping_data,'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id,'acharge'=>$affilate_charge]);                 
                    }
        }

    }//







    public function cashondelivery(Request $request)
    {
      
      
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        $gs = Generalsetting::findOrFail(1);
        $prom = Promotional::findOrFail(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);


        foreach ($cart->items as $pro) {
            $mn=Product::find($pro['item']['id'])->pro_owner;
            $proid=Product::find($pro['item']['id'])->proid;
            $message="Dear Merchant, Your product has been ordered. Product Id:".$proid." Please check orderlist";
            $phone=Admin::where('username',$mn)->first()->phone;
            SMS::sendSms(urlencode($message),$phone);
        }

        foreach($cart->items as $key => $prod)
        {
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
                foreach($prod['item']['license_qty']as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = $produc->license_qty;
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp =  $produc->license;
                        $license = $temp[$ttl];
                         $oldCart = Session::has('cart') ? Session::get('cart') : null;
                         $cart = new Cart($oldCart);
                         $cart->updateLicense($prod['item']['id'],$license);  
                         Session::put('cart',$cart);
                        break;
                    }                    
                }
        }
        }

     

        $order = new Order;
        $orderid=rand(1000,99999);
       

        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $gs->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        //$order['cart'] = utf8_encode(bzcompress(serialize($cart), 9)); 
        $order['cart'] =serialize($cart);

        //====affilate charge====
        $maintotal = [];
         foreach($cart->items as $pdata){
            $maintotal[] = ($pdata['item']['price']*$pdata['qty']);
         }

         $totalPrice=$cart->totalPrice;
         $company_get= array_sum($maintotal);
         $affilate_charge=($totalPrice-$company_get);

     
        
        



        $order['totalQty'] = $request->totalQty;


            if ($request->total > 400) {

               $order['pay_amount'] = round($request->total / $curr->value, 2) + 0 + $request->packing_cost;

            }elseif ($request->total > 300 && $request->total < 400) {

                $order['pay_amount'] = round($request->total / $curr->value, 2) + ($request->shipping_cost*50)/100 + $request->packing_cost;

            }else{

                $order['pay_amount'] = round($request->total / $curr->value, 2) + $request->shipping_cost + $request->packing_cost;
            }
       
       //$order['pay_amount'] = round($request->total / $curr->value, 2) + $request->shipping_cost + $request->packing_cost;
       

        $order['method'] = $request->method;
        // $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = $orderid;
        $order['customer_address'] = $request->address;
        $order['customer_city'] = $request->city;
        $order['order_note'] = $request->order_notes;
        $order['affilate_charge'] = $affilate_charge;
        $order['affilate_user'] = Auth::user()->ref_user;
        $order['company_get'] = $company_get;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending"; 
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;

        $order->save();


        $checkorder=Order::where('affilate_user',Auth::user()->ref_user)->count();
        if ($checkorder==2) {
            $parent=User::where('ref_user',Auth::user()->parentuser)->first();
            if (!is_null($parent)) {
                $parent->incomebalance+=50;
                $user=Auth::user();
                $user->incomebalance +=50;
                $parent->save();
                $user->save();
              
            }
        }
        

        $to=$request->phone;
        $facebook_page="fb.me/afnep";
        $message="Congratulations!You have successfully placed your order from ".$facebook_page." Your order id is : ".$orderid." Soon we'll contact for confirming your order.";

        $to=$request->phone;
        $get=SMS::sendSms(urlencode($message),$to);
        if ($get) {
            $track = new OrderTrack;
            $track->title = 'Pending';
            $track->text = 'You have successfully placed your order.';
            $track->order_id = $order->id;
            $track->save();

            $notification = new Notification;
            $notification->order_id = $order->id;
            $notification->save();
                        if($request->coupon_id != "")
                        {
                           $coupon = Coupon::findOrFail($request->coupon_id);
                           $coupon->used++;
                           if($coupon->times != null)
                           {
                                $i = (int)$coupon->times;
                                $i--;
                                $coupon->times = (string)$i;
                           }
                            $coupon->update();

                        }

            foreach($cart->items as $prod)
            {
                $x = (string)$prod['size_qty'];
                if(!empty($x))
                {
                    $product = Product::findOrFail($prod['item']['id']);
                    $x = (int)$x;
                    $x = $x - $prod['qty'];
                    $temp = $product->size_qty;
                    $temp[$prod['size_key']] = $x;
                    $temp1 = implode(',', $temp);
                    $product->size_qty =  $temp1;
                    $product->update();               
                }
            }


            foreach($cart->items as $prod)
            {
                $x = (string)$prod['stock'];
                if($x != null)
                {

                    $product = Product::findOrFail($prod['item']['id']);
                    $product->stock =  $prod['stock'];
                    $product->update();  
                    if($product->stock <= 5)
                    {
                        $notification = new Notification;
                        $notification->product_id = $product->id;
                        $notification->save();                    
                    }              
                }
            }




            Session::put('temporder',$order);
            Session::put('tempcart',$cart);

            Session::forget('cart');

                Session::forget('already');
                Session::forget('coupon');
                Session::forget('coupon_total');
                Session::forget('coupon_total1');
                Session::forget('coupon_percentage');
                Session::forget('affiliateuser');

            //Sending Email To Buyer

            if($gs->is_smtp == 1)
            {
            $data = [
                'to' => $request->email,
                'type' => "new_order",
                'cname' => $request->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'wtitle' => "",
                'onumber' => $order->order_number,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendAutoOrderMail($data,$order->id);            
            }
            else
            {
               $to = $request->email;
               $subject = "Your Order Placed!!";
               $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number." Please wait for your delivery. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
               mail($to,$subject,$msg,$headers);            
            }
            //Sending Email To Admin
            if($gs->is_smtp == 1)
            {
                $data = [
                    'to' => $gs->email,
                    'subject' => "New Order Recieved!!",
                    'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
                ];

                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($data);            
            }
            else
            {
               $to = $gs->email;
               $subject = "New Order Recieved!!";
               $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
               mail($to,$subject,$msg,$headers);
            }

            return redirect($success_url)->with('rmessage','Your your order has been placed successfully.Soon we will contact with your. Thank you.');;
        }else{
            Session::flash('errormessage', 'Something wents wrong. Please try again');
            return back();
        }

       
    }

    public function gateway(Request $request)
    {
        

        $gs = Generalsetting::findOrFail(1);
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);


        foreach ($cart->items as $pro) {
            $mn=Product::find($pro['item']['id'])->pro_owner;
            $proid=Product::find($pro['item']['id'])->proid;
            $message="Dear Merchant, Your product has been ordered. Product Id:".$proid." Please check orderlist";
            $phone=Admin::where('username',$mn)->first()->phone;
            SMS::sendSms(urlencode($message),$phone);
        }
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        foreach($cart->items as $key => $prod)
        {
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
                foreach($prod['item']['license_qty']as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = $produc->license_qty;
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp =  $produc->license;
                        $license = $temp[$ttl];
                         $oldCart = Session::has('cart') ? Session::get('cart') : null;
                         $cart = new Cart($oldCart);
                         $cart->updateLicense($prod['item']['id'],$license);  
                         Session::put('cart',$cart);
                        break;
                    }                    
                }
        }
        }



        $settings = Generalsetting::findOrFail(1);
        $orderid=rand(1000,99999);
        $prom = Promotional::findOrFail(1);

        
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        //$order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
          $order['cart'] =serialize($cart);
        $order['totalQty'] = $request->totalQty;



         //====affilate charge====
         $maintotal = [];
          foreach($cart->items as $pdata){
             $maintotal[] = ($pdata['item']['price']*$pdata['qty']);
          }

          $totalPrice=$cart->totalPrice;
          $company_get= array_sum($maintotal);
          $affilate_charge=($totalPrice-$company_get);

       

          // end affilate


        
        if ($request->total > 400) {
           $order['pay_amount'] = round($request->total / $curr->value, 2) + 0 + $request->packing_cost;
        }elseif ($request->total > 300 && $request->total < 400) {
            $order['pay_amount'] = round($request->total / $curr->value, 2) +($request->shipping_cost*50)/100 + $request->packing_cost;
        }else{
            $order['pay_amount'] = round($request->total / $curr->value, 2) + $request->shipping_cost + $request->packing_cost;
        }

        //$order['pay_amount'] = round($request->total / $curr->value, 2) + $request->shipping_cost + $request->packing_cost;
        $order['method'] = $request->method;
        // $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = $orderid;
        $order['customer_address'] = $request->address;
        $order['customer_city'] = $request->city;
        $order['order_note'] = $request->order_notes;
        $order['txnid'] = $request->txn_id4;
        $order['affilate_user']=Auth::user()->ref_user;
        $order['company_get']=$company_get;
        $order['affilate_charge']=$affilate_charge;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order->save();


        $checkorder=Order::where('affilate_user',Auth::user()->ref_user)->count();
        if ($checkorder==2) {
            $parent=User::where('ref_user',Auth::user()->parentuser)->first();
            if (!is_null($parent)) {
                $parent->incomebalance+=50;
                $user=Auth::user();
                $user->incomebalance +=50;
                $parent->save();
                $user->save();
              
            }
        }


        
        $facebook_page="fb.me/afnep";
        $message="Congratulations!You have successfully placed your order from ".$facebook_page." Your order id id ".$orderid." Soon we'll contact for confirming your order.";

        $to=$request->phone;
        $get=SMS::sendSms(urlencode($message),$to);

        if ($get) {
           
           $track = new OrderTrack;
           $track->title = 'Pending';
           $track->text = 'You have successfully placed your order.';
           $track->order_id = $order->id;
           $track->save();
           
           $notification = new Notification;
           $notification->order_id = $order->id;
           $notification->save();
                       if($request->coupon_id != "")
                       {
                          $coupon = Coupon::findOrFail($request->coupon_id);
                          $coupon->used++;
                          if($coupon->times != null)
                          {
                               $i = (int)$coupon->times;
                               $i--;
                               $coupon->times = (string)$i;
                          }
                           $coupon->update();

                       }

           foreach($cart->items as $prod)
           {
               $x = (string)$prod['size_qty'];
               if(!empty($x))
               {
                   $product = Product::findOrFail($prod['item']['id']);
                   $x = (int)$x;
                   $x = $x - $prod['qty'];
                   $temp = $product->size_qty;
                   $temp[$prod['size_key']] = $x;
                   $temp1 = implode(',', $temp);
                   $product->size_qty =  $temp1;
                   $product->update();               
               }
           }


           foreach($cart->items as $prod)
           {
               $x = (string)$prod['stock'];
               if($x != null)
               {

                   $product = Product::findOrFail($prod['item']['id']);
                   $product->stock =  $prod['stock'];
                   $product->update();  
                   if($product->stock <= 5)
                   {
                       $notification = new Notification;
                       $notification->product_id = $product->id;
                       $notification->save();                    
                   }              
               }
           }

           Session::put('temporder',$order);
           Session::put('tempcart',$cart);
           Session::forget('cart');
           Session::forget('already');
           Session::forget('coupon');
           Session::forget('coupon_total');
           Session::forget('coupon_total1');
           Session::forget('coupon_percentage');
           Session::forget('affiliateuser');



           

           //Sending Email To Buyer
           if($gs->is_smtp == 1)
           {
           $data = [
               'to' => $request->email,
               'type' => "new_order",
               'cname' => $request->name,
               'oamount' => "",
               'aname' => "",
               'aemail' => "",
               'wtitle' => "",
               'onumber' => $order->order_number,
           ];

           $mailer = new GeniusMailer();
           $mailer->sendAutoOrderMail($data,$order->id);            
           }
           else
           {
              $to = $request->email;
              $subject = "Your Order Placed!!";
              $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
               $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
              mail($to,$subject,$msg,$headers);            
           }
           //Sending Email To Admin
           if($gs->is_smtp == 1)
           {
               $data = [
                   'to' => $gs->email,
                   'subject' => "New Order Recieved!!",
                   'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
               ];

               $mailer = new GeniusMailer();
               $mailer->sendCustomMail($data);            
           }
           else
           {
              $to = $gs->email;
              $subject = "New Order Recieved!!";
              $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
               $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
              mail($to,$subject,$msg,$headers);
           }

            return redirect($success_url)->with('rmessage','Your your order has been placed successfully.Soon we will contact with your. Thank you.');

        }else{
            Session::flash('errormessage', 'Something wents wrong. Please try again');
            return back();
        }






       

    }


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

}
