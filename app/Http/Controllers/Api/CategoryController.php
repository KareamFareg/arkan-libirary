<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class CategoryController extends Controller
{
    public function MainpgAPI()
    {
        $category = DB::table('category')->select('id','name')->where("parents",'0')->get();
        $alldata=array();
        $data=array();
        $Books['books']=array();
        $i=0;
        foreach($category as $eachcat)
        {
            $id=$eachcat->id;
            $Books = DB::select("SELECT `id`,`name`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `cat_id`='$id' ORDER BY `products`.`id` DESC");
            if(count($Books)>0){
                $alldata[$i]=new \stdClass();
                $alldata[$i]->id=$eachcat->id;
                $alldata[$i]->name=$eachcat->name;
                $alldata[$i]->books=$Books;
                $i++;
            }
        }
        if(count($category)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$alldata]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }
    }
    public function all()
    {
        $category = DB::table('category')->select('id','name')->where("parents",'0')->get();
        foreach($category as $eachcat)
        {
            $id=$eachcat->id;
            $subCates =  DB::table('category')->where("parents",$id)->get();
            if(count($subCates)>0){
                $eachcat->subCates = $subCates;
            }
        }
        if(count($category)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الأقسام ','Data'=>$category]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد أقسام','Data'=>[]]);

        }
    }
    public  function getMainCatAPI()
    {
        //$category = DB::table('category')->select('id','name')->where("parents",'0')->get();
        $category=DB::select("SELECT * FROM `category` WHERE parents=0 and (SELECT COUNT(*) from `products` WHERE`products`.`cat_id`=`category`.`id`)>0");
        if(count($category)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الداتا ','Data'=>$category]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);

        }

    } 
    public  function getSubCatAPI($id)
    {
        $category = DB::table('category')->select('id','name')->where("parents",$id)->get();
        if(count($category)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الداتا ','Data'=>$category]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);

        }

    }


	
}