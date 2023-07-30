<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    //
    public function register(Request $request)
    {

        $user_reg=new User();
        $user_reg->name=$request->name;
        $user_reg->email=$request->email;
        $user_reg->phone=$request->phone;
        $user_reg->country_id=$request->country_id;
       // $user_reg->city=$request->city;
        $user_reg->address=$request->address;
        $user_reg->longitude=$request->longitude;
        $user_reg->latitude=$request->latitude;
        $user_reg->currency=$request->currency;
        $user_reg->password= Hash::make($request->password);
        $user_reg->type= 3;
        $loginData=User::where('email', $user_reg->email)->first();
        if(!$loginData){
            $user_reg->save();//($request->all);
            $user_reg->mesg='1';
            return response()->json(['code'=>200,"status"=>'success','message'=>'بيانات المستخدم ','Data'=>$user_reg]);
        }
        else{
            return response()->json(['code'=>200,"status"=>'error','message'=> 'البريد الإلكتروني مسجل من قبل','Data'=>[]]);

        }
               
    }
    public function login(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $loginData=User::where('email', $email)->first();
        if($loginData && Hash::check($request->password,$loginData->password) )
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'بيانات المستخدم ','Data'=>$loginData]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=> 'البريد الإلكتروني او كلمة المرور خطا','Data'=>[]]);

        }
    }    

  
}
