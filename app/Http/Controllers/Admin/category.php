<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\categoryModel;
use Hash;
use Auth;


class category extends Controller
{
    public function __construct()
    {
        $this->middleware('can:category-create', ['only' => ['addcategory','addsubcategory','insertcategory']]);
        $this->middleware('can:category-read',   ['only' => ['view', 'viewsingle']]);
        $this->middleware('can:category-update',   ['only' => ['editcategory','updatecategory']]);
        $this->middleware('can:category-delete',   ['only' => ['deletecategory']]);
    }
    public function addcategory()
    {
        if(Auth::user()->type == 0)
       {
        $parent=0;
        return view('admin.category.add',compact('parent'));
       }
       else
       {
        return redirect('/logout');
       }
    } 
   public function addsubcategory($id)
    {
        if(Auth::user()->type==0)
       {
        $parent=$id;
        return view('admin.category.add',compact('parent'));
       }
       else
       {
        return redirect('/logout');
       }
    } 
 
    public function editcategory($id)
    
    {
        if(Auth::user()->type==0)
       {
        $content = DB::table('category')->where('id',$id)->get();
        return view('admin.category.edit',compact('content'));
       }
       else
       {
        return redirect('/logout');
       }
    }

########
    public function  insertcategory(Request $request)
    {
        if(Auth::user()->type==0)
       {
        $category=new categoryModel();
        $category->name=$request->name;
        $category->parents=$request->parents;
       
        $Result= $category->save();

        if($Result==1)
        {
            toastr()->success('تم الحفظ بنجاح', 'Success Message');
        }
        else
        {
            toastr()->error('هناك خطأ', 'Error Message');
        }
         return redirect('/BookCategory/view/');
    }
    else
    {
     return redirect('/logout');
    }
        
    }    
    public function  updatecategory(Request $request)
    {
        if(Auth::user()->type==0)
       {
        $category=new categoryModel();
        $category->exists = true;
        $category->id=$request->id;
        $category->name=$request->name;
        $Result= $category->save();

        if($Result==1)
        {
            toastr()->success('تم الحفظ بنجاح', 'Success Message');
        }
        else
        {
            toastr()->error('هناك خطأ', 'Error Message');
        }
         return redirect('/BookCategory/view');
    }
    else
    {
     return redirect('/logout');
    }
        
    }



    ##########
    public function view ()
    {
       //return view('admin.content.view');
       if(Auth::user()->type==0)
       {
        $Content =DB::select("select * from category where parents=0");
        if(count($Content)>0){
        }
        else
        {
            toastr()->error('لا يوجد بيانات', 'Error Message');

        }
        return view('admin.category.view', compact('Content'));

       }
       else
       {
        return redirect('/logout');

       }
       

    }  
    public function viewsingle($id)
    {
       //return view('admin.content.view');
       if(Auth::user()->type==0)
       {
        $Content =DB::select("select * from category where parents='$id'");
        if(count($Content)>0){
        }
        else
        {
            toastr()->error('لا يوجد بيانات', 'Error Message');

        }
        return view('admin.category.view', compact('Content'));

       }
       else
       {
        return redirect('/logout');

       }
       

    }  
    
    public function deletecategory($id)
    {
     DB::table('category')->where('id', $id)->delete();
     toastr()->success('تم الحذف بنجاح', 'Success Message');
     return redirect('/BookCategory/view');
    }
    

}
