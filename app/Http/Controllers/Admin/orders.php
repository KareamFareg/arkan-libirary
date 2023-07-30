<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Alert;
use App\Models\ordersModel;
use DB;
use App\Services\NotificationService;
class orders extends Controller
{
    private $notificationServ;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationServ = $notificationService;

    
        $this->middleware('can:orders-read',   ['only' => ['order_details','view']]);
        $this->middleware('can:orders-update',   ['only' => ['accept']]);


    }
   
       public function order_details($id)
       {
           $data = DB::select("SELECT *,(SELECT users.name from users WHERE users.id=`customer_id`) as 'customer_name',(SELECT users.phone from users WHERE users.id=`customer_id`) as 'customer_phone',(SELECT users.address from users WHERE users.id=`customer_id`) as 'customer_address',(SELECT users.email from users WHERE users.id=`customer_id`) as 'customer_email',(SELECT products.name from products WHERE products.id=`item_id`)as'product_name',(SELECT products.img from products WHERE products.id=`item_id`)as'product_img' FROM `order_details` WHERE `order_id`='$id';");
           return view('admin.orders.viewDetails',compact('data'));
       } 
       public function accept($t,$id)
       {
            $order = ordersModel::find($id);
            $order->status = $t;
            $Result = $order->save();
            if ($Result == 1) {
                toastr()->success('تم قبول الطلب بنجاح', 'Success Message');

            } else {
                toastr()->error('هناك خطأ', 'Error Message');

            }
            // if($t= 1){
            //     $this->notificationServ->notifyOrderAccepted(
            //         ['fcm', 'db'],
            //         ['order_id' => $order->id]
            //     );
            
            // }else{
            //     $this->notificationServ->notifyCancelOrder(
            //         ['fcm', 'db'],
            //         ['order_id' => $order->id, 'canceld_by' => 1]
            //     );
            // }

            return redirect('/orders/view');
        }
        public function view()
       {
            $currentorders=DB::select("select *,(select count(*) from order_details where order_id=orders.id) as 'items',(select name from users where cust_id=users.id) as 'cust_name' from orders  WHERE `status`='0' and type=0");
            $finishedorders=DB::select("select *,(select count(*) from order_details where order_id=orders.id) as 'items',(select name from users where cust_id=users.id) as 'cust_name' from orders  WHERE `status`='1' and type=0");
            $canceledorders=DB::select("select *,(select count(*) from order_details where order_id=orders.id) as 'items',(select name from users where cust_id=users.id) as 'cust_name' from orders  WHERE `status`='-1' and type=0");
            return view('admin.orders.view',compact('currentorders','finishedorders','canceledorders'));
       }
   }
