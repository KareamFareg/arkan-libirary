<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Ebook;

use Auth;


class EbooksController extends Controller
{
    //
   
    public function getBookById($id)

    {
        $EN = env('EN_ENABLED');
       
        $ebook = DB::table('ebooks')->where('id', $id)->first();
        $subcats = DB::table('category')->select('id', 'name','parents')->where('id',$ebook->subcat_id)->first();
        $cats = DB::table('category')->select('id', 'name')->where('id', $ebook->cat_id)->first();
        $ebook->cat_id = $cats;
        $ebook->subcat_id = $subcats;
        return response()->json(['code'=>200,"status"=>'success','message'=>' تفاصيل الكتب ','Data'=>$ebook]);

    }
    public function all($id)

    {
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ");

        return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب الألكترونيه ','Data'=>$Content]);

    }
    public function getByUserid($user_id)

    {
        
        $where=" where user_id='".$user_id."'";
        $user = DB::table('users')->where('id', $user_id)->first();
        if($user->isadmin == 1){
            $Content = DB::select("select *,(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
            $Content[0]->user_name = 'الادمن';
        }else{
            $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
        }
        if (count($Content) > 0) {
        } else {
            return response()->json(['code' => 200, "status" => 'error', 'message' => 'لا يوجد بيانات', 'Data' => []]);
        }
        return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب الألكترونيه ','Data'=>$Content]);

    }

    ########
    public function  insertebook(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'details' => 'required',
            'image' => 'required|image',
            'writer_name' => 'required',
            'discount' => 'required',
             'user_id'=>'required',
            'cat' => 'required',
            'subcat' => 'required',
            'parts'=> 'numeric',
            'pages'=> 'numeric',
            'language'=> 'required',

        ]);

        if ($validator) {
            if(isset($request->image)){
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $filename = '/images/' . $imageName;
            }
            if(isset($request->file)){
                $target_file = public_path('files') . basename($_FILES["file"]["name"]);
                $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $fileName = time() . '.' . $extension;
                $request->file->move(public_path('files'), $fileName);
                $filePdfName = '/files/' . $fileName;
            }

           
            $ebook = new Ebook();
            $ebook->name = $request->name;
            $ebook->writer_name = $request->writer_name;
            $ebook->details = $request->details;
            $ebook->image = $filename;
            $ebook->file = $filePdfName;
            $ebook->extension = $extension;
            $ebook->user_id = $request->user_id;
            $ebook->price = $request->price;
            $ebook->discount = $request->discount;
            $ebook->price_after_discount = $request->price - (($request->discount / 100) * $request->price);
            $ebook->cat_id = $request->cat;
            $ebook->subcat_id = $request->subcat;
            $ebook->parts = $request->parts;
            $ebook->pages = $request->pages;
            // $ebook->date = $request->date;
            $ebook->language = $request->language;

            $Result = $ebook->save();
            return response()->json(['code' => 200, "status" => 'success', 'message' => 'تم اضافه المنتج بنجاح', 'Data' => $ebook]);
        }else{
           return response()->json(['code'=>500,"status"=>'error','message'=>'Validaition faild','Data'=>[]]);
        }
    }
    public function updateebook(Request $request)
    {

        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'cat' => 'required',
            'subcat' => 'required',
            'details' => 'required',
            'image' => 'nullable|image',
            'file' => 'nullable|mimes:pdf|max:10000',
            'discount' => 'required',
            'writer_name' => 'required',

        ]);

        if ($validator) {

            $ebook = DB::table('ebooks')->where('id', $request->id)->first();
            $ebook->name = $request->name;
            $ebook->writer_name = $request->writer_name;
            $ebook->details = $request->details;

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $filename = '/images/' . $imageName;
                $ebook->image = $filename;
            }
            if ($request->hasFile('file')) {
                $target_file = public_path('files') . basename($_FILES["file"]["name"]);
                $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $fileName = time() . '.' . $extension;
                $request->file->move(public_path('files'), $fileName);
                $filePdfname = '/files/' . $fileName;

                $ebook->file = $filePdfname;
                $ebook->extension = $extension;
            }

            $ebook->user_id = $request->user_id;
            $ebook->price = $request->price;
            $ebook->discount = $request->discount;
            $ebook->price_after_discount = $request->price - (($request->discount / 100) * $request->price);

            $ebook->cat_id = $request->cat;
            $ebook->subcat_id = $request->subcat;
            $ebook->parts = $request->parts;
            $ebook->pages = $request->pages;
            $ebook->date = $request->date;
            $ebook->language = $request->language;

          
            $Result = $ebook->save();
            return response()->json(['code' => 200, "status" => 'success', 'message' => 'تم تعديل المنتج بنجاح', 'Data' => $ebook]);
        }else{
           return response()->json(['code'=>500,"status"=>'error','message'=>'Validaition faild','Data'=>[]]);
        }
          
        }
   


    ##########
    
    
    public function searchebook(Request $request)
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
            $where=" where user_id='".$request->user_id."' and name LIKE '%$txt%''";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
        if (count($Content) > 0) {
        } else {
            return response()->json(['code' => 200, "status" => 'error', 'message' => 'لا يوجد بيانات', 'Data' => []]);
        }
        return response()->json(['code' => 200, "status" => 'success', 'message' => 'تفاصيل المنتج', 'Data' => $Content]);
    }


    public function deleteebook($id)
    {
        DB::table('ebooks')->where('id', $id)->delete();
        Alert::success('تم الحذف بنجاح', 'Success Message');
        return response()->json(['code' => 200, "status" => 'success', 'message' => 'تم حذف المنتج بنجاح', 'Data' => []]);
    } 
    public function featuredEbooks($id)
    {
        $ebook= DB::table('ebooks')
            ->where('id', $id)
            ->update(['featured' =>1]);
       
        return response()->json(['code' => 200, "status" => 'success', 'message' => 'تفاصيل المنتج', 'Data' => [$ebook]]);

    } 
}
