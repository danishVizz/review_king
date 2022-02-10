<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Validator;
use Auth;

class CategoryController extends Controller
{
    public $CategoryObj;
    public $UserObj;

    public function __construct()
    {
        $this->CategoryObj = new Category();
        $this->UserObj = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category = Category::all();
        // $data = Category::Paginate(10);
        $posted_data = array();
        $posted_data['paginate'] = 10;
        if(Auth::user()->role == 2){
            $posted_data['user_id'] = Auth::user()->id;
        }
        $data = $this->CategoryObj->getCategory($posted_data);
    
        return view('deal.list', compact('data'));
    }



    public function create()
    {

        $posted_data = array();
        $posted_data['role'] = 2;
        $posted_data['orderBy_name'] = 'name';
        $posted_data['orderBy_value'] = 'asc';
        $data['company'] = $this->UserObj->getUser($posted_data);
        
        return view('deal.add', compact('data'));
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
            'order_number' => 'required',
            'description' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            // ->withInput($request->except('password'));
        } else {
                $posted_data = $request->all();
                $posted_data['user_id'] = isset($posted_data['company'])? $posted_data['company']: Auth::user()->id;


                $this->CategoryObj->saveUpdateCategory($posted_data);

                \Session::flash('message', 'Deal created successfully!');
                return redirect('/deal');
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

        $data = $this->CategoryObj->getCategory($posted_data);


        $posted_data = array();
        $posted_data['role'] = 2;
        $posted_data['orderBy_name'] = 'name';
        $posted_data['orderBy_value'] = 'asc';
        $data['company'] = $this->UserObj->getUser($posted_data);

        return view('deal.add',compact('data'));
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
            'order_number' => 'required',
            'description' => 'required',
        ]);
   
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();   
        }
   
        $posted_data = $request->all();
        $posted_data['user_id'] = isset($posted_data['company'])? $posted_data['company']: Auth::user()->id;
        $posted_data['update_id'] = $id;

        $this->CategoryObj->saveUpdateCategory($posted_data);

        \Session::flash('message', 'Deal updated successfully!');
        return redirect('/deal');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Category $category)
    public function destroy($id)
    {
        // $category->delete();
        $data = Category::find($id);
        $data->delete();

        \Session::flash('message', 'Deal deleted successfully!');
        return redirect('/deal');
    }


    public function GetCategoryDeletedRecord()
    {
        return Category::onlyTrashed()->get();
    }

    public function RestoreCategoryDeletedRecord()
    {
        return Category::withTrashed()->restore();
    }

    public function ForceDeleteCategoryRecord()
    {
        // return Category::withTrashed()->find(1)->forceDelete();
        return Category::withTrashed()->forceDelete();
    }

    
}