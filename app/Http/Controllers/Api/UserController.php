<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;


class  UserController extends Controller
{
     public function getAllWritersAPI()
    {
        
        $Data=User::where('type', 4)->get();
        if(count($Data))
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'كل الكتاب','Data'=>$Data]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=> "لا يوجد داتا",'Data'=>[]]);

        }
    } 
    public function updateFcm(Request $request,$id)
    {

        $this->validate($request, [
            'fcm_token' => 'required',
            'mobile_type' => 'required|max:30|in:android,ios',
        ]);

        $user = User::find($id);
        $update= $user->update(['fcm_token' => $request->fcm_token, 'mobile_type' => $request->mobile_type]);
        // $update = $this->userServ->updateFcm($user, $request);
        if (!$update) {
            return response()->json(['code'=>200,"status"=>'error','message'=> "هناك خطأ ما ",'Data'=>[$user]]);

        }
        // success
        return response()->json(['code'=>200,"status"=>'success','message'=>'تم الحفظ بنجاح','Data'=>[$user]]);
    }
   
    public function getalllibrariesAPI()
    {
        $Data=User::where('type', 1)->get();
        if(count($Data))
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'كل المكتبات','Data'=>$Data]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=> "لا يوجد داتا",'Data'=>[]]);

        }
    } 
    public function getDarelnashrAPI()
    {
        
        $Data=User::where('type',2 )->get();
        if(count($Data))
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'كل دار النشر','Data'=>$Data]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=> "لا يوجد داتا",'Data'=>[]]);

        }
    }
    public function getuserbyID($id)
    {
        $loginData=DB::select("SELECT `id`,`name`,`email`,`phone`,`job`,`city`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name',`currency`,(select countries_withcurrency.currency_name FROM countries_withcurrency where countries_withcurrency.id=currency) as'currency_name' ,`address`,`img`,(SELECT COUNT(*) from `orders` where `orders`.`cust_id`=`users`.`id`) as'purchaseorders' FROM `users` where `id`='$id' and `type`='3';");//User::where('id', $id)->first();
        if($loginData)
        {                   
            $Books = DB::select("SELECT `id`,`name`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`quantity`,`status` FROM `products` where `id` IN (select `book_id` from `bookfav` where `user_id`='$id') ORDER BY `products`.`id` DESC");
            $loginData[0]->Books=$Books;
            return response()->json(['code'=>200,"status"=>'success','message'=>'بيانات المستخدم','Data'=>$loginData[0]]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=> "لا يوجد داتا",'Data'=>[]]);
        }
    }
    public function updateProfile(Request $request)
    {
        $id=$request->id;
        $name=$request->name;
        $phone=$request->phone;
        //$city=$request->city;
        $country_id=$request->country_id;
        $currency=$request->currency;
        $address=$request->address;
        $job=$request->job;
        DB::update('update users set  name=?,phone=?, address=?, job=?, country_id=?, currency=? where id=?', [$name,$phone,$address,$job,$country_id,$currency,$id]);
        return response()->json(['code'=>200,"status"=>'success','message'=>'تم الحفظ بنجاح','Data'=>[]]);

    }
   

}
