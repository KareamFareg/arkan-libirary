<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{

    public function convertcurrency($id)
    {
        $users=DB::select("SELECT *,(SELECT  `countries_withcurrency`.`currency` FROM `countries_withcurrency` where `countries_withcurrency`.`id`=`users`.currency) as'currency_name' FROM `users` where `id`=$id");
        if(count($users)>0)
        {
            $cu=$users[0]->currency_name;
            if($cu!='')
            {
            $url = 'https://api.exchangerate-api.com/v4/latest/USD';
            $json = file_get_contents($url);
            $exp = json_decode($json);
            $convert = $exp->rates->$cu;
        //    $r= $convert * $amount;
            return response()->json(['code'=>200,"status"=>'success','message'=>'العمله ','Data'=>$convert]);

            }
            else
            {
                return response()->json(['code'=>200,"status"=>'error','message'=>"برجاء اختيار العمله",'Data'=>[]]);
            }
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>"لا توجد داتا",'Data'=>[]]);
        }
            
    }


	
}