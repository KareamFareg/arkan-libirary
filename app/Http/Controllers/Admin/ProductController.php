<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\productsModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Auth;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('can:products-create', ['only' => ['addproduct','insertproduct']]);
        $this->middleware('can:products-read',   ['only' => ['view', 'viewsingle','searchproduct']]);
        $this->middleware('can:products-update',   ['only' => ['editproduct','updateproduct']]);
        $this->middleware('can:products-delete',   ['only' => ['deleteproduct']]);
    }
    public function addproduct()

    {

        $EN = env('EN_ENABLED');
        $city = DB::table('city')->select('id', 'name')->get();
        $cats = DB::table('category')->select('id', 'name')->where('parents', '0')->get();
        $countries = DB::table('countries')->select('id','country_arName')->get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();
        $publisher = DB::table('users')->select('id', 'name')->where('type', '2')->get();
        return view('admin.products.add', compact('city', 'writer', 'cats','countries','publisher'));
    }

    public function editproduct($id)

    {

        $EN = env('EN_ENABLED');
        $city = DB::table('city')->select('id', 'name')->get();
        $cats = DB::table('category')->select('id', 'name')->where('parents', '0')->get();
        $content = DB::table('products')->where('id', $id)->first();
        $countries = DB::table('countries')->select('id','country_arName')->get();
        $subcats = DB::table('category')->select('id', 'name')->where('parents', $content->cat_id)->get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();
        $publisher = DB::table('users')->select('id', 'name')->where('type', '2')->get();
        return view('admin.products.edit', compact('city', 'writer', 'content', 'cats', 'subcats','countries','publisher'));
    }

    ########
    public function  insertproduct(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'status' => 'required',
            'city' => 'required',
            'address' => 'required',
            'cat' => 'required',
            'subcat' => 'required',
            'details' => 'required',
            'image' => 'required|image',
            'writer_id' => 'required',
            'publisher_id' => 'required',
            'discount' => 'required',
            'booksize' => 'required',
            'numpg' => 'required',
        ]);

        if ($validator) {
            
            $product = new productsModel();

            if(isset($request->image)){
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $filename = '/images/' . $imageName;
            }
            
            $product->name = $request->name;
            $product->writer_id = $request->writer_id;
            $product->publisher_id = $request->publisher_id;
            $product->details = $request->details;
            $product->img = $filename;
            $product->user_id = Auth::user()->id;
            $product->price = $request->price;
            $product->price_after_discount=$request->price-(($request->discount/100)*$request->price);
            $product->cat_id = $request->cat;
            $product->subcat_id = $request->subcat;
            $product->address = $request->address;
            $product->country_id = $request->country_id;
            $product->city_id = $request->city;
            $product->status = $request->status;
            $product->quantity = $request->quantity;
            $product->discount = $request->discount;
            $product->numpg = $request->numpg;
            $product->booksize = $request->booksize;
            $product->notes = $request->notes;

            $Result = $product->save();

            if ($Result == 1) {
                toastr()->success('تم الحفظ بنجاح', 'Success Message');
            } else {
                toastr()->error('هناك خطأ', 'Error Message');
            }
        } else {
            toastr()->error('هناك خطأ', 'Error Message');
        }
        return redirect('/products/view');
    }
    public function  updateproduct(Request $request)
    {

        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'status' => 'required',
            'city' => 'required',
            'writer_id' => 'required',
            'publisher_id' => 'required',
            'address' => 'required',
            'cat' => 'required',
            'subcat' => 'required',
            'details' => 'required',
            'image' => 'nullable|image',
            'discount' => 'required',
            'booksize' => 'required',
            'numpg' => 'required',
            
        ]);

        if ($validator) {

            $product = new productsModel();
            $product->exists = true;
            $product->id = $request->id;
            $product->name = $request->name;
            $product->details = $request->details;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $filename = '/images/' . $imageName;
                $product->img = $filename;
            }
            $product->user_id = Auth::user()->id;
            $product->price = $request->price;
            $product->price_after_discount=$request->price-(($request->discount/100)*$request->price);
            $product->cat_id = $request->cat;
            $product->subcat_id = $request->subcat;
            $product->address = $request->address;
            $product->country_id = $request->country_id;
            $product->city_id = $request->city;
            $product->status = $request->status;
            $product->quantity = $request->quantity;
            $product->writer_id = $request->writer_id;
            $product->publisher_id = $request->publisher_id;
            $product->discount = $request->discount;
            $product->numpg = $request->numpg;
            $product->booksize = $request->booksize;
            $product->notes = $request->notes;


            $Result = $product->save();

            if ($Result == 1) {
                toastr()->success('تم الحفظ بنجاح', 'Success Message');
            } else {
                toastr()->error('هناك خطأ', 'Error Message');
            }
        } else {
            toastr()->error('هناك خطأ', 'Error Message');
        }
        return redirect('/products/view');
    }



    ##########
    public function view()
    {
        //return view('admin.content.view');
        $isadmin=Auth::user()->isadmin;
        
        if($isadmin=='1')
        {
            $where='';
        }
        else
        {
            $where=" where user_id='".Auth::user()->id."'";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select users.name from users where users.id=writer_id) as 'writer_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from products ".$where);
        if (count($Content) > 0) {
        } else {
            toastr()->error('لا يوجد بيانات', 'Error Message');
        }
        return view('admin.products.view', compact('Content'));
    }
    public function viewsingle ($id)
    {
        $isadmin=Auth::user()->isadmin;
       if($isadmin=='1')
       {
           $where='';
       }
       else
       {
           $where=" and user_id='".Auth::user()->id."'";
       }
       $Content = DB::select("select *,(select users.name from users where users.id=writer_id) as 'writer_name',(select users.name from users where users.id=user_id) as 'user_name',(select city.name from city where city.id=city_id) as 'city_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from products where id='$id' ". $where);
      
        if(count($Content)>0){
           
           
            $orders=DB::select("SELECT *,(SELECT orders.status from orders WHERE orders.id=`order_id`) as 'status',(SELECT users.name from users WHERE users.id=customer_id) as 'cust_name' FROM `order_details` WHERE `item_id`='$id'");
            return view('admin.products.viewsingle', compact('Content','orders'));

            

        }
        else
        {
            return redirect('/home');

        }
        

    }  
    public function searchproduct(Request $request)
    {
        //return view('admin.content.view');
        $txt = $request->search;
        $isadmin=Auth::user()->isadmin;
        if($isadmin=='1')
        {
            $where="where name LIKE '%$txt%'";
        }
        else
        {
            $where=" where user_id='".Auth::user()->id."' and name LIKE '%$txt%''";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=writer_id) as 'writer_name',(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from products ".$where);
        if (count($Content) > 0) {
        } else {
            toastr()->error('لا يوجد بيانات', 'Error Message');
        }
        return view('admin.products.view', compact('Content'));
    }


    public function deleteproduct($id)
    {
        DB::table('products')->where('id', $id)->delete();
        toastr()->success('تم الحذف بنجاح', 'Success Message');
        return redirect('/products/view');
    } 
    public function featuredProduct($id,$f)
    {
        DB::table('products')
            ->where('id', $id)
            ->update(['featured' => $f]);
       
        toastr()->success('تم إضافته للمميز بنجاح', 'Success Message');
        return redirect('/products/view');
    } 
}

