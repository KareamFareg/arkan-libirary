<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\bookfavModel;



class FavouriteController extends Controller
{
    public function addfavBook(Request $request)
    {
        $book_id = $request->book_id;
        $user_id = $request->user_id;
        $data=DB::select("select * from  `bookfav` where `book_id`='$book_id' and `user_id`='$user_id'");
        if(count($data)==0){
        $fav= new bookfavModel();
        $fav->book_id=$request->book_id;
        $fav->user_id=$request->user_id;
        $fav->save();
        return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه الكتاب الي المفضله','Data'=>$fav]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>'تم الادخال من قبل','Data'=>[]]);
        }
    }
    public function getFavBookByUserId($id){
        $Books = DB::select("SELECT `id`,`name`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`quantity`,`status` FROM `products` where `id` IN (select `book_id` from `bookfav` where `user_id`='$id') ORDER BY `products`.`id` DESC");
        if(count($Books)>0){

               return response()->json(['code'=>200,"status"=>'success','message'=>'  الكتب المفضله','Data'=>$Books]);

            }
            else
            {
                return response()->json(['code'=>200,"status"=>'error','message'=>'لا توجد كتب مفضله','Data'=>[]]);
    
            }
    }
    public function deletefavBook(Request $request)
    {
        $book_id = $request->book_id;
        $user_id = $request->user_id;
        $data=DB::select("select * from  `bookfav` where `book_id`='$book_id' and `user_id`='$user_id'");
        if(count($data)>0){
        $deleted = bookfavModel::where('id', $data[0]->id)->delete();
        return response()->json(['code'=>200,"status"=>'success','message'=>"تم الحذف",'Data'=>[]]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لا توجد كتب مفضله','Data'=>[]]);

        }
    }
	
}