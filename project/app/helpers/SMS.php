<?php 
namespace App\helpers;
//use App\Models\Api;
use Auth;
use App\Models\Order;
use App\Aorder;
use App\Models\User;
use App\Models\Api;

class SMS
{
	
	
	public static function sendSms($message,$to)
	{
		$api=Api::find(1);
		$get="http://api.greenweb.com.bd/api.php?token=".$api->data."&to=".$to."&message=".$message;
       
	    $client = new \GuzzleHttp\Client();
        $res = $client->get($get);
        $content = (string) $res->getBody();
        return $content;
	}

	public static function pendingbal($username)
	{
		$ocoms=Order::where('affilate_user','=',$username)->where('status','=','pending')->orWhere('status','=','processing')->orWhere('status','=','on delivery')->sum('affilate_charge');

		return $ocoms;
	}
	public static function affpendingbal($username)
	{
		 $coms=Aorder::where('username',$username)->sum('commission');
		  return $coms;
	}
	public static function incomebalance($id)
	{
		 $income=User::where('id',$id)->sum('incomebalance');
		  return $income;
	}
	
}

