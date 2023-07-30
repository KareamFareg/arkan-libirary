<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\productsModel;


class BookController extends Controller
{
    public function addBook(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'status' => 'required',
            'city' => 'required',
            'address' => 'required',
            'cat' => 'required',
            'subcat' => 'required',
            'details' => 'required',
            'image' => 'required|image',
            'writer_id' => 'required',
            'publisher_id' => 'required',
            'discount' => 'required',
            'booksize' => 'required',
            'numpg' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $filename = '/images/' . $imageName;
            $product = new productsModel();
            $product->name = $request->name;
            $product->writer_id = $request->writer_id;
            $product->publisher_id = $request->publisher_id;
            $product->details = $request->details;
            $product->img = $filename;
            $product->user_id = $request->user_id;
            $product->price = $request->price;
            $product->price_after_discount=$request->price-(($request->discount/100)*$request->price);
            $product->cat_id = $request->cat;
            $product->subcat_id = $request->subcat;
            $product->address = $request->address;
            $product->country_id = $request->country_id;
            $product->city_id = $request->city;
            $product->status = $request->status;
            $product->quantity = $request->quantity;
            $product->discount = $request->discount;
            $product->numpg = $request->numpg;
            $product->booksize = $request->booksize;
            $product->notes = $request->notes;

            $Result = $product->save();
            return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه المنتج بنجاح','Data'=>$product]);

    }
    else
    {
        return response()->json(['code'=>500,"status"=>'error','message'=>'Validaition faild','Data'=>[]]);
    }
}
    
    public function BooksBycat_id($id)
    {
        $Books = DB::select("SELECT `id`,`name`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `cat_id`='$id' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'الكتب الخاصه بقسم معين','Data'=>$Books]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب في هذا القسم','Data'=>$Books]);
        }

    } 
    public function BooksFeatured()
    {
        $Books = DB::select("SELECT `id`,`name`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `featured`='1' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$Books]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }

    }
     public function Bookbyid($id)
    {
        $Books = DB::select("SELECT `id`,`name`,`numpg`,`booksize`,`notes`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `id`='$id' ");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' تفاصيل الكتب ','Data'=>$Books[0]]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب بهذا الرقم','Data'=>[]]);

        }

    }
     public function Booksbywriter($id)
    {
        $Books = DB::select("SELECT `id`,`name`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `writer_id`='$id' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب الخاص بهذا الكاتب','Data'=>$Books]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب لهذا الكاتب','Data'=>[]]);
        }

    }  
    public function Booksbyuser($id)
    {
        $Books = DB::select("SELECT `id`,`name`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `user_id`='$id' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$Books]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }

    }    
    public function Booksneworused($id)
    {
        $Books = DB::select("SELECT `id`,`name`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `status`='$id' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$Books]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }

    } 
    public function searchbyBooks(Request $request)
    {
        $name=$request->title;
        $city_id=$request->city_id;
        $country_id=$request->country_id;
        $where='';
        if($name!='')
        {
            $where=" where `name`like '%$name%' ";
        }
        if($city_id!='')
        {
            if($where=='')
            {           
                 $where=" where `city_id`='$city_id' ";
            }
            else
            {
                $where=$where." and `city_id`='$city_id' ";

            }
        }
 if($country_id!='')
        {
            if($where=='')
            {           
                 $where=" where `country_id`='$country_id' ";
            }
            else
            {
                $where=$where." and `country_id`='$country_id' ";

            }
        }

        $Books = DB::select("SELECT `id`,`name`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products`  $where ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$Books]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }

    }  
    public function Booksoffers()
    {
        $Books = DB::select("SELECT `id`,`name`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `discount`>'0' ORDER BY `products`.`id` DESC");
        if(count($Books)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>' كل الكتب ','Data'=>$Books]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'لا يوجد كتب','Data'=>[]]);

        }

    }
}