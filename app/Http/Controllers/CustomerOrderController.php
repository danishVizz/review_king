<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerOrder;
use App\Models\Category;
use App\Models\RenewStampcard;
use QrCode;
use Validator;
use Session;
use DB;
use Auth;

class CustomerOrderController extends Controller
{
    public $UserObj;
    public $CustomerOrderObj;

    public function __construct()
    {
        $this->UserObj = new User();
        $this->CustomerOrderObj = new CustomerOrder();
        $this->CategoryObj = new Category();
        $this->RenewStampcardObj = new RenewStampcard();
    }

    
    public function ConfirmOrder(Request $request)
    {
        // $rules = array(
        //     'phone_number' => 'required',
        // );
        // $validator = Validator::make($request->all(), $rules);


        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|min:13',
        ],[
            'phone_number.min' => 'Phone Number must be 10 characters long.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            
            $posted_data = $request->all();
            $slug = substr(md5(time()), 0, 16);
            $posted_data['slug'] = $slug;
            $posted_data['user_id'] = $posted_data['company_id'];
            $this->CustomerOrderObj->saveUpdateCustomerOrder($posted_data);

            $user_posted_data = array();
            $user_posted_data['update_id'] = $posted_data['company_id'];
            $user_posted_data['slug'] = '';
            $this->UserObj->saveUpdateUser($user_posted_data);

            \Session::flash('message', 'Order created successfully!');
            return redirect('/stampcard/'.$slug);
        }
    }
    

    public function view_stampcard(Request $request)
    {
        $posted_data = array();
        $posted_data['role'] = 2;
        $posted_data['orderBy_name'] = 'name';
        $posted_data['orderBy_value'] = 'asc';
        $data['company'] = $this->UserObj->getUser($posted_data);
        
        return view('view_stampcard', compact('data'));
    }

    
    public function check_view_stampcard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|min:13',
            'company' => 'required',
        ],[
            'phone_number.min' => 'Phone Number must be 10 characters long.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            
            $posted_data = $request->all();
            $user_posted_data = array();
            $user_posted_data['phone_number'] = $posted_data['phone_number'];
            $user_posted_data['user_id'] = $posted_data['company'];
            $user_posted_data['detail'] = true;
            $user_posted_data['status'] = 0;
            $user_posted_data['orderBy_name'] = 'id';
            $user_posted_data['orderBy_value'] = 'desc';
            $order_detail = $this->CustomerOrderObj->getCustomerOrder($user_posted_data);

            if($order_detail){
                $slug = $order_detail->slug;
                return redirect('/stampcard/'.$slug);
            }else{
                // \Session::flash('error_message', 'Your Phone Number is invalid you dont have any new order with this number, thanks!');
                \Session::flash('error_message', 'You dont have any new order with this number in this company, thanks!');
                // return redirect('/view_stampcard');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }
    
    public function stampcard($slug)
    {
        $data = array();
        $user_posted_data = array();
        $user_posted_data['slug'] = $slug;
        $user_posted_data['detail'] = true;
        $order_detail = $this->CustomerOrderObj->getCustomerOrder($user_posted_data);

        if($order_detail){
            $user_posted_data = array();
            $user_posted_data['phone_number'] = $order_detail->phone_number;
            $user_posted_data['user_id'] = $order_detail->user_id;
            $user_posted_data['status'] = 0;
            $user_posted_data['orderBy_name'] = 'id';
            $user_posted_data['orderBy_value'] = 'desc';
            $customer_orders = $this->CustomerOrderObj->getCustomerOrder($user_posted_data);
            $data['customer_orders'] = $customer_orders;

            $posted_data = array();
            $posted_data['user_id'] = $order_detail->user_id;
            $posted_data['detail'] = true;
            $posted_data['orderBy_name'] = 'order_number';
            $posted_data['orderBy_value'] = 'desc';
            $last_gift = $this->CategoryObj->getCategory($posted_data);
            if($last_gift){
                $data['last_gift'] = $last_gift;
            }
        }
        // app('App\Models\Category')->getCategory($posted_data);
        // echo '<pre>';
        // print_r($data);
        // exit;
        
        return view('stampcard',compact('data'));
    }


    public function renew_stampcard(Request $request)
    {
        $request_data = $request->all();
        
        $posted_data = array();
        $posted_data['user_id'] = $request_data['user_id'];
        $posted_data['phone_number'] = $request_data['phone_number'];
        $posted_data['detail'] = true;
        $renew_stampcard_detail = $this->RenewStampcardObj->getRenewStampcard($posted_data);


        $fltr_posted_data = array();
        $fltr_posted_data['status'] = 0;
        $fltr_posted_data['phone_number'] = $request_data['phone_number'];
        $fltr_posted_data['user_id'] = $request_data['user_id'];
        $fltr_posted_data['count'] = true;
        $total_renew_orders = $this->CustomerOrderObj->getCustomerOrder($fltr_posted_data);
        // $inst_posted_data = array();
        if($renew_stampcard_detail){
            $posted_data['update_id'] = $renew_stampcard_detail->id;
            $posted_data['stampcard_count'] = $renew_stampcard_detail->stampcard_count + 1;
            $posted_data['total_renew_orders'] = $renew_stampcard_detail->total_renew_orders.','.$total_renew_orders;
        }else{
            $posted_data['total_renew_orders'] = $total_renew_orders;
        }

        $this->RenewStampcardObj->saveUpdateRenewStampcard($posted_data);

        $this->CustomerOrderObj->renew_stampcard($posted_data);

        
        $response = array();
        $response['data'] = $request_data;
        echo json_encode($response);
        exit;
    }


    public function customer_orders(Request $request)
    {
        $request_data = $request->all();
        // SELECT *, count(id) as total_orders FROM `customer_orders` GROUP BY user_id
        $posted_data = array();
        $posted_data['paginate'] = 10;
        if(Auth::user()->role == 2){
            $posted_data['user_id'] = Auth::user()->id;
            $posted_data['groupBy'] = 'phone_number';
        }else{
            $posted_data['groupBy'] = 'user_id';
            $posted_data['groupBy2'] = 'phone_number';
        }
        if(isset($request_data['company_name']) && !empty($request_data['company_name'])){
            $posted_data['company_name'] = $request_data['company_name'];
        }
        if(isset($request_data['phone_number']) && !empty($request_data['phone_number'])){
            $posted_data['phone_number_like'] = $request_data['phone_number'];
        }
        $posted_data['status'] = 0;
        $posted_data['orderBy_name'] = 'id';
        $posted_data['orderBy_value'] = 'desc';
        $data = $this->CustomerOrderObj->getCustomerOrder($posted_data);
        // $data['request_data'] = $request_data;

        // echo '<pre>';
        // print_r($data->toArray());
        // exit;

        return view('customer_orders',compact('data'),compact('request_data'));
    }




    public function old_customer_orders(Request $request)
    {
        $request_data = $request->all();
        // SELECT *, count(id) as total_orders FROM `customer_orders` GROUP BY user_id
        $posted_data = array();
        $posted_data['paginate'] = 10;
        if(Auth::user()->role == 2){
            $posted_data['user_id'] = Auth::user()->id;
            $posted_data['groupBy'] = 'phone_number';
        }else{
            $posted_data['groupBy'] = 'user_id';
            $posted_data['groupBy2'] = 'phone_number';
        }
        if(isset($request_data['company_name']) && !empty($request_data['company_name'])){
            $posted_data['company_name'] = $request_data['company_name'];
        }
        if(isset($request_data['phone_number']) && !empty($request_data['phone_number'])){
            $posted_data['phone_number_like'] = $request_data['phone_number'];
        }
        $posted_data['status'] = 1;
        $posted_data['orderBy_name'] = 'id';
        $posted_data['orderBy_value'] = 'desc';
        $data = $this->CustomerOrderObj->getCustomerOrder($posted_data);
        // $data['request_data'] = $request_data;

        // echo '<pre>';
        // print_r($data->toArray());
        // exit;

        return view('customer_orders',compact('data'),compact('request_data'));
    }
    
}