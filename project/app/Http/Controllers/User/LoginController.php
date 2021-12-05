<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function showLoginForm()
    {
      //$this->code_image();
      return view('user.login');
    }


    public function refuser($refuser){
     

      return view('user.login',compact('refuser'));
    }

    public function login(Request $request)
    {
       
       $this->validate($request,[
          'phone'=>'required',
          'password'=>'required'
       ],[
          'phone.required'=>'Enter your phone number',
          'password.required'=>'Enter your password',
       ]);

       $user=User::where('phone',$request->phone)->first();
       if (!is_null($user)) {
          if ($user->useractive==1) {
            if (Auth::guard('web')->attempt(['phone'=>$request->phone,'password'=>$request->password])) {
                return redirect()->intended(route('user-dashboard'));
            }else{
               session()->flash('errormessage','Credentials did not matched');
               return back();
            }

           
          }else{
                session()->flash('errormessage','Your account is not active yet. Active your account'); 
                Session::put('user_id',$user->id);  
                return redirect('user/verifycode');
          }

          Session::put('user_id',$user->id);
          
       }else{
          session()->flash('errormessage','User not found. Please register now');
          return back();
       }
        
            
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
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
