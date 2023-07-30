<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
Use Alert;
use Hash;
use Auth;


class customers extends Controller
{
    
    public function addcustomer($id)
    
    {
        if($id==3)
        {
            if(Auth::user()->type!=0)
            {
                return redirect('/logout');

            }
        }
        
        $EN=env('EN_ENABLED');
        $countries = DB::table('countries')->select('id','country_arName')->get();
        $city = DB::table('city')->select('id','name')->get();
        $cats = DB::table('category')->select('id','name')->where('parents','0')->get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();

        return view('admin.customers.add',compact('city','EN','id','cats','countries','writer'));
    } 
    public function getsubcat($id)   
    {   
        $states = DB::table("category")
                ->where("parents",$id)
                ->get();
                $res="<option>اختر القسم الفرعي</option>";
                foreach($states as $st)
                {
                    $res=$res."<option value='".$st->id."'>".$st->name."</option>";
                }
                echo $res;
    }   
    public function getcitybyid($id)
    {
        $states = DB::table("city")
                ->where("country_id",$id)
                ->get();
                $res="<option>اختر  المدنيه</option>";
                foreach($states as $st)
                {
                    $res=$res."<option value='".$st->id."'>".$st->name."</option>";
                }
                echo $res;
     
    } 
    public function editcustomer($id)
    
    {
        
        $EN=env('EN_ENABLED');
        $countries = DB::table('countries')->select('id','country_arName')->get();
        $city = DB::table('city')->select('id','name')->get();
        $cats = DB::table('category')->select('id','name')->where('parents','0')->get();
        $content = DB::table('users')->where('id',$id)->get();
        $subcats = DB::table('category')->select('id','name')->where('parents',$content[0]->cat)->get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();

        $type=$content[0]->type;
        if($type==3)
        {
            if(Auth::user()->type!=0)
            {
                return redirect('/logout');

            }
        }
        return view('admin.customers.edit',compact('city','EN','content','cats','subcats','type','countries','writer'));
    }

########
    public function  insertcustomer(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:users',
        ]);
        if ($validator) {
            if ($request->type == 3) {
                if (Auth::user()->type != 0) {
                    return redirect('/logout');

                }
            }
            $customer = new User();
            $customer->name = $request->name;
            $customer->password = Hash::make('123456');
            $customer->type = $request->type;
            if ($request->type == 1) {
                $customer->address = $request->address;
                $customer->latitude = $request->latitude;
                $customer->longitude = $request->longitude;
            }
            if ($request->type != 4) {
                $customer->country_id = $request->country_id;
                // $customer->city=$request->city;
                $customer->phone = $request->phone;
                $customer->email = $request->email;

            } else {
                $customer->email = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

            }
            $customer->insertedby = Auth::user()->id;
            if ($request->type == 4) {
                $customer->cat = $request->cat;
                //$customer->subcat=$request->subcat;
            }
            $Result = $customer->save();

            if ($Result == 1) {
                toastr()->success('تم الحفظ بنجاح', 'Success Message');

            } else {
                toastr()->error('هناك خطأ', 'Error Message');

            }
        }else{
            toastr()->error('الأسم موجود من قبل', 'Error Message');

        }
         return redirect('/customer/view/'.$request->type);
        
    }    
    public function  updatecustomer(Request $request)
    {
        if($request->type==3)
        {
            if(Auth::user()->type!=0)
            {
                return redirect('/logout');

            }
        }
        
        $customer=new User();
        $customer->exists = true;
        $customer->id=$request->id;
        
        if($request->name != $customer->name){
            $validator = $request->validate([
                'name' => 'required|unique:users',
            ]);
        }
        $customer->name=$request->name;
        $customer->country_id=$request->country_id;
       // $customer->city=$request->city;
        if($request->type==4)
        {
        $customer->cat=$request->cat;
        //$customer->subcat=$request->subcat;
        }
        else
        {
            $customer->email=$request->email;
            $customer->phone=$request->phone;
        }
        $Result= $customer->save();

        if($Result==1)
        {
            toastr()->success('تم الحفظ بنجاح', 'Success Message');

        }
        else
        {
            toastr()->error('هناك خطأ', 'Error Message');

        }
         return redirect('/customer/view/'.$request->type);
        
    }



    ##########
    public function view ($id)
    {
       $where='';
       if(Auth::user()->type!=0)
       {
           $where=" and insertedby='".Auth::user()->id."'";
       }
        $Content =DB::select("select *,(select category.name from category where category.id=cat) as 'cat_name',(select category.name from category where category.id=subcat) as 'subcat_name' from users where type = '$id' $where");
        if(count($Content)>0){
        }
        else
        {
            toastr()->error('لا يوجد بيانات', 'Error Message');

        }
        return view('admin.customers.view', compact('Content','id'));

    }  
    public function viewsingle ($id)
    {
       //return view('admin.content.view');
       
        $Content =DB::table('users')->where('id',$id)->get();
        $cityname='';
        if(count($Content)>0){
            $city=DB::table('city')->where('id',$Content[0]->city)->get();
            if(count($city)>0)
            {
                $cityname=$city[0]->name;
            }
            if($Content[0]->type==3)
            {
            $orders=DB::select("select *,(select count(*) from order_details where order_id=orders.id) as 'items' from orders where cust_id='$id'");
            return view('admin.customers.viewsingle', compact('Content','cityname','orders'));
            }
            else
            {
                $orders=DB::select("select * from products where user_id='$id'");
                return view('admin.customers.viewwriter', compact('Content','cityname','orders'));
            }

            

        }
        else
        {
            return redirect('/home');

        }
        

    }  
    public function searchcustomer ($id,Request $request)
    {
     if(!isset($id)){
        $id = 1;
     }
       //return view('admin.content.view');
       $txt=$request->search;
       $where='';
       if(Auth::user()->type!=0)
       {
           $where=" and insertedby='".Auth::user()->id."'";
       }
        $Content =DB::select("SELECT * FROM `users` WHERE (name LIKE '%$txt%' or email LIKE '%$txt%') and type= $id  $where;");
        if(count($Content)>0){
        }
        else
        {
            toastr()->error('لا يوجد بيانات', 'Error Message');

        }
     
        return view('admin.customers.view', compact('Content','id'));

    }

    
    public function deletecustomer($id)
    {
     DB::table('users')->where('id', $id)->delete();
     toastr()->success('تم الحذف بنجاح', 'Success Message');
     return redirect('/customer/view/3');
    }

}
