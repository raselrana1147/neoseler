<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HomeMeta;
use Illuminate\Support\Facades\Input;
use Datatables;

class HomeMetaController extends Controller
{
    
	public function __construct()
	{
	    $this->middleware('auth:admin');
	    $this->middleware('superadmin');
	}

    public function home_content(){
        $metas=HomeMeta::all();
        return view('admin.homepage.index',compact('metas'));
    }


    public function change_shopping(Request $request,$id){

        	$data = HomeMeta::findOrFail($id);
        	$input = $request->all();
        	    if ($file = $request->file('meta_value')) 
        	    {              
        	        $name = time().$file->getClientOriginalName();
        	        $file->move('assets/admin/meta/',$name);
        	        if($data->meta_value != null)
        	        {
        	            if (file_exists(public_path().'/assets/admin/meta/'.$data->meta_value)) {
        	                unlink(public_path().'/assets/admin/meta/'.$data->meta_value);
        	            }
        	        }            
        	    $input['meta_value'] = $name;

        	    } 

        	$input['meta_title']=$request->meta_title;
        	$input['meta_content']=$request->meta_content;
        	$data->update($input);
        	//--- Logic Section Ends

        	//--- Redirect Section  
        	$notification=array(
        	   'rmessage'=>'Successfully Updated',
        	   'alert-type'=>'success'
        	);

        	return redirect(route('home.page.content'))->with($notification);   
        	  
    }

    public function change_merchant(Request $request, $id)
    {
    	$data = HomeMeta::findOrFail($id);
    	$input = $request->all();
    	    if ($file = $request->file('meta_value')) 
    	    {              
    	        $name = time().$file->getClientOriginalName();
    	        $file->move('assets/admin/meta/',$name);
    	        if($data->meta_value != null)
    	        {
    	            if (file_exists(public_path().'/assets/admin/meta/'.$data->meta_value)) {
    	                unlink(public_path().'/assets/admin/meta/'.$data->meta_value);
    	            }
    	        }            
    	    $input['meta_value'] = $name;
    	    } 

    	$input['meta_title']=$request->meta_title;
    	$input['meta_content']=$request->meta_content;
    	$data->update($input);
    	//--- Logic Section Ends

    	//--- Redirect Section  
    	$notification=array(
    	   'rmessage'=>'Successfully Updated',
    	   'alert-type'=>'success'
    	);

    	return redirect(route('home.page.content'))->with($notification);
    }

    public function change_reseller(Request $request, $id)
    {
    	$data = HomeMeta::findOrFail($id);
    	$input = $request->all();
    	    if ($file = $request->file('meta_value')) 
    	    {              
    	        $name = time().$file->getClientOriginalName();
    	        $file->move('assets/admin/meta/',$name);
    	        if($data->meta_value != null)
    	        {
    	            if (file_exists(public_path().'/assets/admin/meta/'.$data->meta_value)) {
    	                unlink(public_path().'/assets/admin/meta/'.$data->meta_value);
    	            }
    	        }            
    	    $input['meta_value'] = $name;
    	    } 

    	$input['meta_title']=$request->meta_title;
    	$input['meta_content']=$request->meta_content;
    	$data->update($input);
    	//--- Logic Section Ends

    	//--- Redirect Section  
    	$notification=array(
    	   'rmessage'=>'Successfully Updated',
    	   'alert-type'=>'success'
    	);

    	return redirect(route('home.page.content'))->with($notification);
    }
}
