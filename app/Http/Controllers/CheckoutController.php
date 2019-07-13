<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
 use App\Http\Requests;
 use Session;
 use Cart;
 use Illuminate\Support\Facades\Redirect;
 session_start();

class CheckoutController extends Controller
{
    public function login_check()
    {
    	return view('pages.login');
    }

    public function customer_registration(Request $request)
    {
    	$data=array();
    	$data['customer_id']=$request->customer_id;
    	$data['customer_reg']=$request->customer_reg;
    	$data['customer_name']=$request->customer_name;
    	$data['customer_email']=$request->customer_email;
    	$data['password']=md5($request->password);
    	$data['mobile_number']=$request->mobile_number;

    	$customer_id=DB::table('tbl_customer')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect::to('/checkout');
    }

    public function checkout()
    {
    	//$all_published_category=DB::table('tbl_category')
         //                 ->where('publication_status',1)
          //                 ->get();
        //$manage_published_category=view('pages.checkout')
          //              ->with('all_published_category',$all_published_category);
        return view('pages.checkout');
    }

    public function save_shipping_details(Request $request)
    {
        $data=array();
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_first_name']=$request->shipping_first_name;
        $data['shipping_last_name']=$request->shipping_last_name;
        $data['shipping_department']=$request->shipping_department;
        $data['shipping_mobile_number']=$request->shipping_mobile_number;

        $shipping_id=DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }

     public function customer_login(Request $request)
    {
        $customer_reg=$request->customer_reg;
        $password=md5($request->password);

        $result1=DB::table('tbl_customer')
                ->where('customer_reg',$customer_reg)
                ->where('password',$password)
                ->first();

        if($result1){

                Session::put('customer_name',$result1->customer_name);
                Session::put('customer_id',$result1->customer_id);
                return Redirect::to('/checkout');
                 
            }else{

                Session::put('message','Email or password invalid');
                return Redirect::to('/login-check');

            }

          
    }
    public function customer_logout(Request $request)
    {
        Session::flush();
        Cart::clear();
        return Redirect::to('/');     
    }

    public function payment()
    {
        return view('pages.payment');
    }

    public function order_place(Request $request)
    {
        $payment_gateway=$request->payment_method;

        $pdata=array();
        $pdata['payment_method']=$payment_gateway;
        $pdata['payment_status']="pending";

        $payment_id=DB::table('tbl_payment')->insertGetId($pdata);

        $odata=array();
        $odata['customer_id']=Session::get('customer_id');
        $odata['shipping_id']=Session::get('shipping_id');
        $odata['payment_id']=$payment_id;
        $odata['order_total']=Cart::getTotal();
        $odata['order_status']="pending";

        $order_id=DB::table('tbl_oreder')->insertGetId($odata);

        $contents=Cart::getContent();
        $oddata=array();
        foreach ($contents as $v_contents) {
            $oddata['order_id']=$order_id;
            $oddata['product_id']=$v_contents->id;
            $oddata['product_name']=$v_contents->name;
            $oddata['product_price']=$v_contents->price;
            $oddata['product_sales_quantity']=$v_contents->quantity;

            DB::table('tbl_order_details')->insert($oddata);
        }
        if ($payment_gateway=="Handcash") {
            echo "Payment successfull with handcash";
            Cart::clear();
        }
        elseif($payment_gateway=="bkash"){
            echo "Payment successfull with bkash";
        }
        else{
            echo "Not selected";
        }
    }

    public function manage_order()
    {
        $all_order_info=DB::table('tbl_oreder')
                        ->join('tbl_customer','tbl_oreder.customer_id','=','tbl_customer.customer_id')
                        
                        ->select('tbl_oreder.*','tbl_customer.customer_name')
                        ->get();
        $manage_order=view('admin.manage_order')
                        ->with('all_order_info',$all_order_info);

        return view('admin_layout')->with('admin.manage_order',$manage_order);
    }
}
