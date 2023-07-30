<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\postsModel;
use App\Models\commentsModel;
use App\Models\likesModel;


class PostController extends Controller
{
    public  function getallpostsAPI($pageNum=1)
    {
        $pageNumber = ($pageNum - 1) * 15;
        $alldata=array();
        $i=0;
        $posts = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_img',(SELECT count(*) from `comments` WHERE `comments`.`post_id`=`posts`.`id`)as 'countcomments',(SELECT count(*) from `likes` WHERE `likes`.`post_id`=`posts`.`id`)as 'countlikes' FROM `posts` order by `id` desc LIMIT 15 OFFSET $pageNumber");
        if (count($posts) > 0) {
            foreach($posts as $eachpost){
                $id=$eachpost->id;
                $bid=$eachpost->book_id;
                $Books = DB::select("SELECT `id`,`name`,`numpg`,`booksize`,`notes`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `id`='$bid' ");
                $likes = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_img' FROM `likes` where `post_id`='$id' and `like`='1' order by `id` ASC");
                $alldata[$i]=new \stdClass();
                $alldata[$i]=$eachpost;
                $alldata[$i]->likes=$likes;
                $alldata[$i]->Book_details=$Books;
                $i++;

            }
            return response()->json(['code'=>200,"status"=>'success','message'=>'all posts ','Data'=>$alldata]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لاتوجد بيانات','Data'=>[]]);

        }
    }
    public function getpostsbyuserIDAPI($id)
    {
        $posts = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_img',(SELECT count(*) from `comments` WHERE `comments`.`post_id`=`posts`.`id`)as 'countcomments',(SELECT count(*) from `likes` WHERE `likes`.`post_id`=`posts`.`id`)as 'countlikes' FROM `posts` where `user_id`='$id' order by `id` desc");
        if (count($posts) > 0) {
            return response()->json(['code'=>200,"status"=>'success','message'=>'all posts ','Data'=>$posts]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لاتوجد بيانات','Data'=>[]]);

        }
    }    
    public function getpostDetailsAPI($id)
    {
        $posts = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`posts`.`user_id`) as 'user_img',(SELECT count(*) from `comments` WHERE `comments`.`post_id`=`posts`.`id`)as 'countcomments',(SELECT count(*) from `likes` WHERE `likes`.`post_id`=`posts`.`id`)as 'countlikes' FROM `posts` where `id`='$id' order by `id` desc");
        if (count($posts) > 0) {
            $comments = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`comments`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`comments`.`user_id`) as 'user_img' FROM `comments` where `post_id`='$id' order by `id` ASC");
            $likes = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_img' FROM `likes` where `post_id`='$id' and `like`='1' order by `id` ASC");
            $dislikes = DB::select("SELECT *,(SELECT `name` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_name',(SELECT `img` from `users` WHERE `users`.`id`=`likes`.`user_id`) as 'user_img' FROM `likes` where `post_id`='$id' and `like`='0' order by `id` ASC");
            if($posts[0]->book_id!=0)
            {
                $bid=$posts[0]->book_id;
                $Books = DB::select("SELECT `id`,`name`,`numpg`,`booksize`,`notes`,`details`,`img`,`date`,`price`,`discount`,`price_after_discount`,`cat_id`,(SELECT `name` from `category` where `category`.`id`=`cat_id`)as 'cat_name',`subcat_id`,(SELECT `name` from `category` where `category`.`id`=`subcat_id`)as 'subcat_name',`user_id` as 'publishedby',(SELECT `name` from `users` where `users`.`id`=`user_id`) as 'publishedBy_name',`writer_id`,(SELECT `name` from `users` where `users`.`id`=`writer_id`) as 'writer_name',`publisher_id`,(SELECT `name` from `users` where `users`.`id`=`publisher_id`) as 'publisher_name',`quantity`,`status`,`city_id`,`country_id`,(SELECT `city`.`name` from `city` where `city`.`id`=`city_id`) as 'city_name',(SELECT `countries`.`country_arName` from `countries` where `countries`.`id`=`country_id`) as 'country_name' FROM `products` where `id`='$bid' ");

            }
            else
            {
                $Books=[];
            }
            return response()->json(['code'=>200,"status"=>'success','message'=>'تفاصيل المنشور ','Data'=>['posts' => $posts[0],'Books' => $Books,'comments'=>$comments,'likes'=>$likes,'dislikes'=>$dislikes]]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لاتوجد بيانات','Data'=>[]]);
        }
    }
    public function  addpostAPI(Request $request)
    {
        $posts = new postsModel();
        $posts->details = $request->details;
        $posts->user_id = $request->user_id;
        $posts->book_id = $request->book_id;
        $Result = $posts->save();
        if ($Result == 1) {
            return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه المنشور بنجاح ','Data'=>$posts]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'هناك خطأ ما ','Data'=>[]]);

        }
    }    
    public function  addfileAPI(Request $request)
    {
        $imageName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('images'), $imageName);
        $filename = '/images/' . $imageName;
        $posts = new postsModel();
        $posts->file = $filename;
        $posts->details = $request->details;
        $posts->user_id = $request->user_id;
        $posts->type = $request->type;
        $Result = $posts->save();
        if ($Result == 1) {
            return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه الملف بنجاح ','Data'=>$posts]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'هناك خطأ ما ','Data'=>[]]);

        }
    }
    public function  addcommentAPI(Request $request)
    {
        $comments = new commentsModel();
        $comments->comment = $request->comment;
        $comments->post_id = $request->post_id;
        $comments->user_id = $request->user_id;
        $Result = $comments->save();
        if ($Result == 1) {
            return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه تعليق بنجاح ','Data'=>$comments]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'هناك خطأ ما ','Data'=>[]]);

        }
    } 
    public function  addlikesAPI(Request $request)
    {
        $post_id = $request->post_id;
        $user_id = $request->user_id;
        $data=DB::select("select * from  `likes` where `post_id`='$post_id' and `user_id`='$user_id'");
        if(count($data)>0)
        {
                DB::table('likes')->where('id', $data[0]->id)->delete();        
        }
        $likes = new likesModel();
        $likes->post_id = $request->post_id;
        $likes->user_id = $request->user_id;
        $likes->like = $request->like;
        $Result = $likes->save();
        if ($Result == 1) {
         return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه اعجاب بنجاح ','Data'=>$likes]);
        } else {
            return response()->json(['code'=>200,"status"=>'error','message'=>'هناك خطأ ما ','Data'=>[]]);

        }
    
    
    }
}
