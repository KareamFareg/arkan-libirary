<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\specialoffersModel;
use RealRashid\SweetAlert\Facades\Alert;



class specialofferscontroller extends Controller
{
    //
    public function view()
    {
        $offers = DB::select("SELECT * FROM `specialoffers` order by id DESC");

        return view('admin.specialoffers.view', compact('offers'));
    }
    public function addFS()
    {
        $Cats = DB::table('sectors')->select('id','name')->get();

        return view('admin.specialoffers.add', compact('Cats'));
    }
    public function editFS($id)
    {
        $Cats = DB::table('sectors')->select('id','name')->get();
        $content = DB::table('specialoffers')->where('id',$id)->get();
        return view('admin.specialoffers.edit',compact('Cats','content'));
    }
    public function deleteFS($id)
    {
        DB::table('specialoffers')->where('id', $id)->delete();
        Alert::success('تم الحذف بنجاح', 'Success Message');
        return redirect('/dashboard/specialoffers/view');
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
        $FS=new specialoffersModel();
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
        return redirect('/dashboard/specialoffers/view');

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
        $FS=new specialoffersModel();
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
        return redirect('/dashboard/specialoffers/view');

    }
}
