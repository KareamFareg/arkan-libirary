<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class CityController extends Controller
{
    public  function getallcityAPI()
    {
        $city = DB::table('city')->select('id','name')->get();
        if(count($city)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل المدن ','Data'=>$city]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);
        }
    }   
     public  function getcitiesbycountryid($id)
    {
        $city = DB::table('city')->select('id','name')->where('country_id',$id)->get();
        if(count($city)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل المدن الخاصه بدوله معينه','Data'=>$city]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);

        }
    }
     public  function getallcountriesAPI()
    {
        $countries = DB::table('countries')->select('id','country_arName')->get();
        if(count($countries)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الدول ','Data'=>$countries]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);

        }

    }
 
  public  function getallcountries_withcurrencyAPI()
    {
        $countries = DB::table('countries_withcurrency')->select()->get();
        if(count($countries)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الدول ','Data'=>$countries]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد داتا','Data'=>[]]);
        }

    }

}

