<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Counter;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;
use App\Models\Slider;


class HomeController extends Controller
{
    

    public function __construct()
    {

        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }
    public function blog(Request $request)
	{
        $this->code_image();
		$blogs = Blog::orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
		return view('user.home.blog',compact('blogs'));
	}
   public function blogshow($id)
   {
      $this->code_image();
       $tags = null;
       $tagz = '';
       $bcats = BlogCategory::all();
       $blog = Blog::findOrFail($id);
       $blog->views = $blog->views + 1;
       $blog->update();
       $name = Blog::pluck('tags')->toArray();
       foreach($name as $nm)
       {
           $tagz .= $nm.',';
       }
       $tags = array_unique(explode(',',$tagz));

       $archives= Blog::orderBy('created_at','desc')->get()->groupBy(function($item){ return $item->created_at->format('F Y'); })->take(5)->toArray();
       $blog_meta_tag = $blog->meta_tag;
       $blog_meta_description = $blog->meta_description;
       return view('user.home.blogshow',compact('blog','bcats','tags','archives','blog_meta_tag','blog_meta_description'));
	}

		public function contact()
		{
	        $this->code_image();
	        if(DB::table('generalsettings')->find(1)->is_contact== 0){
	            return redirect()->back();
	        }        
	        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
			return view('user.home.contact',compact('ps'));
		}



		public function faq()
		{
	        $this->code_image();
	        if(DB::table('generalsettings')->find(1)->is_faq == 0){
	            return redirect()->back();
	        }
	        $faqs =  DB::table('faqs')->orderBy('id','desc')->get();
			return view('user.home.faq',compact('faqs'));
		}




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
