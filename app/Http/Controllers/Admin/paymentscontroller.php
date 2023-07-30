<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\paymentsModel;
use RealRashid\SweetAlert\Facades\Alert;



class paymentscontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payments-create', ['only' => ['addFS','insertFS']]);
        $this->middleware('can:payments-read',   ['only' => ['view', 'editFS']]);
        $this->middleware('can:payments-update',   ['only' => ['editFS','updateFS']]);
        $this->middleware('can:payments-delete',   ['only' => ['deleteFS']]);
    }
    public function view()
    {
        $payments = DB::select("SELECT * FROM `payments` order by id DESC");

        return view('admin.payments.view', compact('payments'));
    }
    public function addFS()
    {
        $Cats = DB::table('sectors')->select('id','name')->get();

        return view('admin.payments.add', compact('Cats'));
    }
    public function editFS($id)
    {
        $Cats = DB::table('sectors')->select('id','name')->get();
        $content = DB::table('payments')->where('id',$id)->get();
        return view('admin.payments.edit',compact('Cats','content'));
    }
    public function deleteFS($id)
    {
        DB::table('payments')->where('id', $id)->delete();
        Alert::success('تم الحذف بنجاح', 'Success Message');
        return redirect('/dashboard/payments/view');
    }
    public function insertFS(Request $request)
    {
        if ($request->hasFile('files')) :
            $images = $request->file('files');
                    $var = date_create();
                    $time = date_format($var, 'YmdHis');
                    $rand=mt_rand(1000000, 9999999);
                    $imageName = $time .$rand. '.' . $images->getClientOriginalExtension();
                    
                    $images->move(public_path('images'), $imageName);
                    $arr = $imageName;
                $image = '/images/'.($arr);

        else:
                $image = '';
        endif;
        $FS=new paymentsModel();
        $FS->title=$request->Title;
        $FS->sector_id=$request->sector_id;
        $FS->details=$request->details;
        $FS->projectdetails=$request->projectdetails;
        $FS->productstudies=$request->productstudies;
        $FS->projectdesc=$request->projectdesc;
        $FS->financial=$request->financial;
        $FS->studycontent=$request->studycontent;
        $FS->country=$request->country;
        $FS->img=$image;
        $Result= $FS->save();

        if($Result==1)
        {
            Alert::success('تم الحفظ بنجاح', 'Success Message');

        }
        else
        {
            Alert::error('هناك خطأ', 'Error Message');

        }
        return redirect('/dashboard/payments/view');

    }
    public function updateFS(Request $request)
    {
        if ($request->hasFile('files')) :
            $images = $request->file('files');
                    $var = date_create();
                    $time = date_format($var, 'YmdHis');
                    $rand=mt_rand(1000000, 9999999);
                    $imageName = $time .$rand. '.' . $images->getClientOriginalExtension();
                    
                    $images->move(public_path('images'), $imageName);
                    $arr = $imageName;
                $image = '/images/'.($arr);

        else:
                $image = '';
        endif;
        $FS=new paymentsModel();
        $FS->exists = true;
        $FS->id=$request->id;
        $FS->title=$request->Title;
        $FS->sector_id=$request->sector_id;
        $FS->details=$request->details;
        $FS->projectdetails=$request->projectdetails;
        $FS->productstudies=$request->productstudies;
        $FS->projectdesc=$request->projectdesc;
        $FS->financial=$request->financial;
        $FS->studycontent=$request->studycontent;
        $FS->country=$request->country;
        if($image!='')
        {
            $FS->img=$image;

        }
        $Result= $FS->save();

        if($Result==1)
        {
            Alert::success('تم الحفظ بنجاح', 'Success Message');

        }
        else
        {
            Alert::error('هناك خطأ', 'Error Message');

        }
        return redirect('/dashboard/payments/view');

    }
}
