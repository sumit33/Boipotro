<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function index(){

    	return view('admin_login');
    }

    
    public function dashboard(Request $request){
    	$admin_email=$request->admin_email;
    	$admin_password=$request->admin_password;
        //$admin_name=$request->admin_name;
        //$admin_id=$request->admin_id;
    	$result=DB::table('tbl_admin')
    		->where('admin_email',$admin_email)
    		->where('admin_password',$admin_password)
    		->first();

           
    		
    		if($result){
    			Session::put('admin_name',$result->admin_name);
    			Session::put('admin_id',$result->admin_id);
    			return Redirect::to('/dashboard');
    		}else{

    			Session::put('message','Email or password invalid');
    			return Redirect::to('/admin');

    		}
    }
}
