<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Auth;

class EBookController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:ebooks-create', ['only' => ['create','store']]);
        $this->middleware('can:ebooks-read',   ['only' => ['show', 'index','show','searchebook']]);
        $this->middleware('can:ebooks-update',   ['only' => ['edit','update','featuredEbooks']]);
        $this->middleware('can:ebooks-delete',   ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // Auth::user()->id= 2;
        $isadmin = 1;
        // $isadmin=Auth::user()->isadmin;
        if($isadmin=='1')
        {
            $where='';
        }
        else
        {
            $where=" where user_id='".Auth::user()->id."'";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
        if (count($Content) > 0) {
        } else {
            toastr()->error('لا يوجد بيانات','Error Message');
        }
        return view('admin.ebooks.view', compact('Content'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $cats = DB::table('category')->select('id', 'name')->where('parents', '0')->get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();

        return view('admin.ebooks.create', compact('cats','writer','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'details' => 'required',
            'image' => 'required|image',
            'writer_name' => 'required',
            'discount' => 'required',
            'image' => 'nullable|image',
            'file' => 'nullable|mimes:pdf|max:10240',
            'cat' => 'required|numeric',
            'subcat' => 'required',
            'parts'=> 'numeric',
            'pages'=> 'numeric',
            'language'=> 'required',

        ]);
           
        if ($validator) {

            $filename = "";
            $filePdfName = "";
            $extension = "";

            $ebook = new Ebook();
            $ebook->name = $request->name;
            $ebook->writer_name = $request->writer_name;
            $ebook->details = $request->details;
            $ebook->image = $filename;
            $ebook->file = $filePdfName;
            $ebook->extension = $extension;
            $ebook->user_id = Auth::user()->id;
            $ebook->price = $request->price;
            $ebook->discount = $request->discount;
            $ebook->price_after_discount=$request->price-(($request->discount/100)*$request->price);
            $ebook->cat_id = $request->cat;
            if(isset( $request->subcat) && $request->subcat != null){
                $ebook->subcat_id = $request->subcat;
            }
            $ebook->parts = $request->parts;
            $ebook->pages = $request->pages;
            // $ebook->date = $request->date;
            $ebook->language = $request->language;

//save image and file
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
            $ebook->image = $filename;
            $ebook->file = $filePdfName;
            $ebook->extension = $extension;

            $Result = $ebook->save();
           
              
    

                // if($request->hasFile('image')){
                //     $avatar = $ebook->addMedia($request->image)->toMediaCollection('image');
                //     $ebook->update(['image'=>$avatar->id.'/'.$avatar->file_name]);
                // }
                // if($request->hasFile('file')){
                //     $file = $ebook->addMedia($request->file)->toMediaCollection('file');
                //     $ebook->update(['file'=>$file->id.'/'.$file->file_name]);
                // }
            if($Result == 1)    {
                toastr()->success('تم إضافة المستخدم بنجاح','Success Message');
               
            }else{
                toastr()->success('هناك خطأ','Error Message');
            }
            return redirect()->route('admin.ebooks.index');
        }
           
       
        
    }
    
    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $isadmin=Auth::user()->isadmin;
        if($isadmin=='1')
        {
            $where=" where id='".$id."'";
        }
        else
        {
            $where=" where user_id='".Auth::user()->id."'";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
        if (count($Content) > 0) {
        } else {
            toastr()->error('لا يوجد بيانات','Error Message');
        }
        return view('admin.ebooks.show', compact('Content'));
    }
    /**
     * 
     */
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
            $where=" where user_id='".Auth::user()->id."' and name LIKE '%$txt%''";
        }
        $Content = DB::select("select *,(select users.name from users where users.id=user_id) as 'user_name',(select category.name from category where category.id=cat_id) as 'cat_name',(select category.name from category where category.id=subcat_id) as 'subcat_name' from ebooks ".$where);
        if (count($Content) > 0) {
        } else {
            toastr()->error(' لا يوجد بيانات','Error Message');
            
        }
        return view('admin.ebooks.view', compact('Content'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)   
    {
        $roles = Role::get();
        $writer = DB::table('users')->select('id', 'name')->where('type', '4')->get();
        $ebook = DB::table('ebooks')->where('id', $id)->first();
        $cats = DB::table('category')->select('id', 'name')->where('parents', '0')->get();
        $subcats = DB::table('category')->select('id', 'name')->where('parents', $ebook->cat_id)->get();

        return view('admin.ebooks.edit', compact( 'ebook','cats', 'subcats','writer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'details' => 'nullable|string',
            'image' => 'required|image',
            'writer_name' => 'required',
            'discount' => 'nullable',
            'image' => 'nullable|image',
            'file' => 'nullable|mimes:pdf|max:10240',
            'cat' => 'required|numeric',
            'subcat' => 'required',
            'parts'=> 'numeric',
            'pages'=> 'numeric',
            'language'=> 'nullable',

        ]);
           
        if ($validator) {
            $extension = "";

            $ebook =  Ebook::find($request->id);
            $ebook->name = $request->name;
            $ebook->writer_name = $request->writer_name;
            $ebook->details = $request->details;
            $ebook->extension = $extension;
            $ebook->user_id = Auth::user()->id;
            $ebook->price = $request->price;
            $ebook->discount = $request->discount;
            $ebook->price_after_discount=$request->price-(($request->discount/100)*$request->price);
            $ebook->cat_id = $request->cat;
            if(isset( $request->subcat) && $request->subcat != null){
                $ebook->subcat_id = $request->subcat;
            }
            $ebook->parts = $request->parts;
            $ebook->pages = $request->pages;
            // $ebook->date = $request->date;
            $ebook->language = $request->language;
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

            $Result = $ebook->save();
            if ($Result == 1) {
                toastr()->success('تم تعديل بيانات الكتاب بنجاح ','Success Message');
               
            }else{
                toastr()->error('هناك خطأ','Error Message');
            }
            return redirect()->route('admin.ebooks.index');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('users-delete'))abort(403);
        $book = Ebook::find($id);
        $book->delete();
        toastr()->success('تم حذف الكتاب بنجاح','عملية ناجحة');
        return redirect()->route('admin.ebooks.index');
    }
    public function featuredEbooks($id,$f)
    {
        DB::table('ebooks')
            ->where('id', $id)
            ->update(['featured' => $f]);
        toastr()->success('تم إضافته للمميز بنجاح','Success Message');
        return redirect('/ebooks/view');
    } 
    public function access(Request $request,User $user){
        if(auth()->user()->hasRole('superadmin')){
            auth()->logout();
            auth()->loginUsingId($user->id);
            return redirect('/');
        }
    }
}
