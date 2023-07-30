<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\cityModel;
Use Alert;
use Hash;
use Auth;


class city extends Controller
{
    public function __construct()
    {
        $this->middleware('can:city-create', ['only' => ['addcity','insertcity']]);
        $this->middleware('can:city-read',   ['only' => ['view']]);
        $this->middleware('can:city-update',   ['only' => ['editcity','updatecity']]);
        $this->middleware('can:city-delete',   ['only' => ['deletecity']]);
    }
    public function addcity()
    {
        
        if(Auth::user()->type==0)
        {
            $countries=DB::select("SELECT * FROM `countries`");
        return view('admin.city.add',compact('countries'));
        }
        else
        {
         return redirect('/logout');
 
        }
     
    } 
 
    public function editcity($id)
    
    {
        if(Auth::user()->type==0)
        {
            $countries=DB::select("SELECT * FROM `countries`");

        $content = DB::table('city')->where('id',$id)->get();
        return view('admin.city.edit',compact('content','countries'));
        }
        else
        {
         return redirect('/logout');
 
        }
    }

########
    public function  insertcity(Request $request)
    {
        if(Auth::user()->type==0)
        {
        $city=new cityModel();
        $city->name=$request->name;
        $city->country_id=$request->country_id;
       
        $Result= $city->save();

        if($Result==1)
        {
            toaster()->success('تم الحفظ بنجاح', 'Success Message');

        }
        else
        {
            toaster()->error('هناك خطأ', 'Error Message');

        }
         return redirect('/city/view');
    }
    else
    {
     return redirect('/logout');

    }
        
    }    
    public function  updatecity(Request $request)
    {
        if(Auth::user()->type==0)
        {
        $city=new cityModel();
        $city->exists = true;
        $city->id=$request->id;
        $city->name=$request->name;
        $city->country_id=$request->country_id;

       
        $Result= $city->save();

        if($Result==1)
        {
            toaster()->success('تم الحفظ بنجاح', 'Success Message');

        }
        else
        {
            toaster()->error('هناك خطأ', 'Error Message');

        }
         return redirect('/dashboard/city/view');
    }
    else
    {
     return redirect('/logout');

    }
        
    }



    ##########
    public function view ()
    {
        if(Auth::user()->type==0)
        {
         $Content =DB::select("select * from city ");
         if(count($Content)>0){
         }
         else
         {
            toaster()->error('لا يوجد بيانات', 'Error Message');
 
         }
         return view('admin.city.view', compact('Content'));
 
        }
        else
        {
         return redirect('/logout');
 
        }

    }  
  
    
    public function deletecity($id)
    {
     DB::table('users')->where('id', $id)->delete();
     toaster()->success('تم الحذف بنجاح', 'Success Message');
     return redirect('/city/view/3');
    }

}

