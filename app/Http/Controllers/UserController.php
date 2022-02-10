<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Validator;
use Session;
use DB;
use Auth;

class UserController extends Controller
{
    public $UserObj;

    public function __construct()
    {
        $this->UserObj = new User();
    }
    public function welcome()
    {
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return redirect('/login');
        }
    }

    public function login()
    {
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('login');
        }
    }

    public function register()
    {
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('register');
        }
    }

    public function privacy_policy()
    {
        return view('privacy_policy');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        $posted_data = array();
        $posted_data['paginate'] = 10;
        $posted_data['role'] = 2;
        $data = $this->UserObj->getUser($posted_data);
    
        return view('company.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|required_with:password|same:password',
            'phone_no' => 'required|min:13',
            'rating_link' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            
                return redirect()->back()->withErrors($validator)->withInput();
            // ->withInput($request->except('password'));
        } else {
            $posted_data = $request->all();
            $posted_data['role'] = 2;

            $this->UserObj->saveUpdateUser($posted_data);

            \Session::flash('message', 'Company created successfully!');
            return redirect('/company');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posted_data = array();
        $posted_data['id'] = $id;
        $posted_data['detail'] = true;

        $data = $this->UserObj->getUser($posted_data);

        return view('company.add',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone_no' => 'required|min:13',
            'rating_link' => 'required',
        ],[
            'phone_no.min' => 'Phone Number must be 10 characters long.',
        ]);
   
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();   
        }else {
            $posted_data = $request->all();
            $posted_data['role'] = 2;
            $posted_data['update_id'] = $id;
            if((isset($posted_data['password']) && !empty($posted_data['password'])) || (isset($posted_data['confirm_password']) && !empty($posted_data['confirm_password']))){
                if($posted_data['password'] != $posted_data['confirm_password']){
                    \Session::flash('error_message', 'Password and Confirm password does not matched!');
                    return redirect()->back()->withErrors($validator)->withInput();  
                }
            }

            $this->UserObj->saveUpdateUser($posted_data);

            \Session::flash('message', 'Company updated successfully!');
            return redirect('/company');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->UserObj->deleteUser($id);

        \Session::flash('message', 'Company deleted successfully!');
        return redirect('/company');
    }



    public function accountLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);     

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }else{
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function forgotPassword()
    {
        return view('auth.forget_password');
    }
    
    public function resetPassword(Request $request)
    {
        $rules = array(
            // 'email' => 'required|email|unique:users',
            'email' => 'required|email',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->to('forgot-password')
                ->withErrors($validator);
        } else {

            $users = User::where('email', '=', $request->input('email'))->first();
            if ($users === null) {
                // echo 'User does not exist';
                Session::flash('error_message', 'Your email does not exists.');
                return redirect('/forgot-password');
            } else {
                // echo 'User exits';
                $random_hash = substr(md5(uniqid(rand(), true)), 10, 10); 
                $email = $request->get('email');
                $password = Hash::make($random_hash);

                // $userObj = new user();
                // $posted_data['email'] = $email;
                // $posted_data['password'] = $password;
                // $userObj->updateUser($posted_data);

                DB::update('update users set password = ? where email = ?',[$password,$email]);


                $data = [
                    'new_password' => $random_hash,
                    'subject' => 'Reset Password',
                    'email' => $email
                ];

                Mail::send('emails.reset_password', $data, function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                });
                Session::flash('message', 'Your password has been changed successfully please check you email!');
                return redirect('/login');
            }

        }
    }


    public function edit_profile()
    {
        $posted_data = array();
        $posted_data['id'] = Auth::user()->id;
        $posted_data['detail'] = true;

        $data = $this->UserObj->getUser($posted_data);

        return view('edit_profile',compact('data'));
    }


    public function update_profile(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone_no' => 'required|min:13',
            'rating_link' => 'required',
        ],[
            'phone_no.min' => 'Phone Number must be 10 characters long.', 
        ]);
   
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();   
        }else {
            $posted_data = $request->all();
            $posted_data['role'] = 2;
            $posted_data['update_id'] = Auth::user()->id;
            if((isset($posted_data['password']) && !empty($posted_data['password'])) || (isset($posted_data['confirm_password']) && !empty($posted_data['confirm_password']))){
                if($posted_data['password'] != $posted_data['confirm_password']){
                    \Session::flash('error_message', 'Password and Confirm password does not matched!');
                    return redirect()->back()->withErrors($validator)->withInput();  
                }
            }

            $this->UserObj->saveUpdateUser($posted_data);

            \Session::flash('message', 'Update profile successfully!');
            return redirect('/edit_profile');
        }
    }
}