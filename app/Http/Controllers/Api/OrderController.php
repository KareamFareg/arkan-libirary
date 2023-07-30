<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ordersModel;
use App\Models\order_detailsModel;



class OrderController extends Controller
{
    public function makeorder(Request $request)
    {
        $validator = $request->validate([
            'cust_id' => 'required',
            'price' => 'required',
        ]);
        if($validator)
        {
            $order=new ordersModel();
            $order->cust_id=$request->cust_id;
            $order->price=$request->price;
            $order->save();

            foreach($request->items as $item){
                $details=new order_detailsModel();
                $details->item_id     =$item['item_id'];
                $details->customer_id =$request->cust_id;
                $details->quantity    =$item['quantity'];
                $details->price       =$item['item_price'];
                $details->order_id    =$order->id;
                $details->save();
            }

            return response()->json(['code'=>200,"status"=>'success','message'=>'تم اضافه طلب بنجاح ','Data'=>$order->id]);

        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>'هناك خطأ ','Data'=>[]]);

        }

    } 
    public function makeorderDetails(Request $request)
    {
        $validator = $request->validate([
            'cust_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'order_id' => 'required',
            'item_id' => 'required',
        ]);
        if($validator)
        {
            $order=new order_detailsModel();
            $order->item_id=$request->item_id;
            $order->customer_id=$request->cust_id;
            $order->quantity=$request->quantity;
            $order->price=$request->price;
            $order->order_id=$request->order_id;
            $order->save();
            $id=$order->id;
            return response()->json(['orderDetails'=>$order,'mesg'=>'success'], 200);

        }
        else
        {
            return response()->json(['mesg' => "validation Error"], 404);

        }

    }
    public function getorderbycustID($id)
    {
        $orders = DB::select("SELECT `id`,`date`,`cust_id`,`status`,`paid`,`price`,(SELECT  SUM(`order_details`.`quantity`) from `order_details` where `order_details`.`order_id`= `orders`.`id`)as'countitems' FROM `orders` where `cust_id`='$id' ORDER BY `orders`.`id` DESC");
        if(count($orders)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'  كل الطلبات','Data'=>$orders]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لا يوجد طلبات','Data'=>[]]);
        }

    } 
    public function getorderDetails($id)
    {
        $orders = DB::select("SELECT *,(SELECT `name` from `products` where `products`.`id`=`item_id`) as 'bname',(SELECT `user_id` from `products` where `products`.`id`=`item_id`) as 'publisher_id',(SELECT `writer_id` from `products` where `products`.`id`=`item_id`) as 'writer_id',(SELECT `img` from `products` where `products`.`id`=`item_id`) as 'bookimg',(SELECT (SELECT users.img from users WHERE users.id=products.writer_id) from `products` where `products`.`id`=`item_id`) as 'bookwriterimg',(SELECT (SELECT users.name from users WHERE users.id=products.writer_id) from `products` where `products`.`id`=`item_id`) as 'bookwritername',(SELECT (SELECT users.img from users WHERE users.id=products.user_id) from `products` where `products`.`id`=`item_id`) as 'bookpublisherimg',(SELECT (SELECT users.name from users WHERE users.id=products.user_id) from `products` where `products`.`id`=`item_id`) as 'bookpublishername',(SELECT `status` FROM `orders` WHERE `orders`.`id`=`order_id`) as 'order_status',(SELECT `paid` FROM `orders` WHERE `orders`.`id`=`order_id`) as 'order_paid' FROM `order_details` WHERE `order_id`='$id'");
        if(count($orders)>0)
        {
            return response()->json(['code'=>200,"status"=>'success','message'=>'تفاصيل الطلب','Data'=>$orders]);
        }
        else
        {
            return response()->json(['code'=>200,"status"=>'error','message'=>'لا يوجد طلب بهذا الرقم','Data'=>[]]);

        }

    } 
   	
}