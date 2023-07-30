<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class ContentController extends Controller
{

    public function showcontent()
    {
        $content = DB::select("SELECT * FROM `content` WHERE `apporsite`='0' order by `orderby` ASC");
        if(count($content)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل المحتوي ','Data'=>$content]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);

        }

    }
	
}