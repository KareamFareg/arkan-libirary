<?php

namespace App\Services;


use App\Traits\FcmNot;
use App\Models\Notification;
use App\Models\User;
class NotificationService
{
    use FcmNot;

    public $locale;


   
    public function notifyOrder($to = [], $params = [])
    {
        $users = $params['users'];

        foreach ($users as $user) {

            // get current item
            $order = Order::where('id', $params['order_id'])->select('id', 'cust_id', 'fcm_token')->first();
            // get user sender
            $user_sender = User::where('id', $order->cust_id)->select('id', 'name')->first();

            $isSentBefore = Notification::where(['user_reciever_id' => $user['id'], 'data' => 'added_new_order', 'table_id' => $params['order_id']])->first();
            if (!$isSentBefore) {
                // get woner of item
                $user_receiver = User::where('id', $user['id'])->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                $this->change_locale($user_receiver->id);
                // fcm
                if (in_array('fcm', $to)) {
                    // prepare for fcm
                    $msg['user_sender'] = $user_sender->id;
                    $msg['user_reciever'] = $user_receiver->id;
                    $msg['order'] = $order->id;
                    $msg['type'] = 1;
                    $msg['title'] = __('messages.new_order');
                    $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->id]);
                    $msg['order_status'] = 1;
                    // $response = $this->notifyFcm($user_receiver, $msg);
                    $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                    if ($response == false) {
                        return false;
                    }
                    // if ($response['result']['failure'] == 1 ){
                    //   return false;
                    // }
                }

                // db
                if (in_array('db', $to)) {
                    $data['user_sender_id'] = $user_sender->id;
                    $data['user_reciever_id'] = $user_receiver->id;
                    $data['table_name'] = 'orders';
                    $data['table_id'] = $order->id;
                    $data['type'] = 1; // order 1 , 2 chat
                    $data['data'] = 'added_new_order';
                    $data['title'] = 'new_order';
                    $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->id];
                    $data['order_status'] = 1;
                    $this->store($data);
                }
            }
        }
        app()->setLocale($this->locale);
        return true;
    }

    public function notifyCreateOrder($to = [], $params = [])
    {
            // get current item
            $order = Order::where('id', $params['order_id'])->select('id', 'cust_id')->first();
            // get user sender
            $user_sender = User::where('id', $order->cust_id)->select('id', 'name')->first();
            $user_receiver = User::where('isadmin', 1)->select('id', 'name', 'fcm_token', 'mobile_type')->first();


            $isSentBefore = Notification::where(['user_reciever_id' => $user_receiver->id,'user_sender_id' => $user_sender->id, 'data' => 'added_new_order', 'table_id' => $params['order_id']])->first();
            if (!$isSentBefore) {
                // get woner of item
                $user_receiver = User::where('isadmin', 1)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                $this->change_locale($user_receiver->id);
                // fcm
                if (in_array('fcm', $to)) {
                    // prepare for fcm
                    $msg['user_sender'] = $user_sender->id;
                    $msg['user_reciever'] = $user_receiver->id;
                    $msg['order'] = $order->id;
                    $msg['type'] = 1;
                    $msg['title'] = __('messages.new_order');
                    $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->id]);
                    $msg['order_status'] = 1;
                    $response = $this->sendGCM($msg,$user_receiver->fcm_token);
                    if ($response === false) {}
                   
                }

                // db
                if (in_array('db', $to)) {
                    $data['user_sender_id'] = $user_sender->id;
                    $data['user_reciever_id'] = $user_receiver->id;
                    $data['table_name'] = 'orders';
                    $data['table_id'] = $order->id;
                    $data['type'] = 1; // order 1 , 2 chat
                    $data['data'] = 'added_new_order';
                    $data['title'] = 'new_order';
                    $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->id];
                    $data['order_status'] = 1;
                    $this->store($data);
                }
            }
    
        app()->setLocale($this->locale);
        return true;
    }

    
    public function notifyOrderAccepted($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'cust_id')->first();
        //admin
        $user_sender = User::where('isadmin', 1)->select('id', 'name')->first();
        // get user sender
        $user_receiver = User::where('id', $order->cust_id)->select('id', 'name' ,'fcm_token', 'mobile_type')->first();
       

        // get woner of item

        $this->change_locale($user_receiver->id);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = $user_sender->id;
            $msg['user_reciever'] = $user_receiver->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = __('messages.order_accepted', ['order_code' => $order->id]);
            $msg['order_status'] = 1;
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = $user_sender->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['data'] = 'order_accepted';
            $data['title'] = 'congrate';
            $data['params'] = ['order_code' => $order->id];
            $data['order_status'] = 2;
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }
    

    
    public function notifyCancelOrder($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'cust_id')->first();
        if ($params['canceld_by'] == 1) {
            // cancel by admin
            $user_sender = User::where('isadmin', 1)->select('id', 'name','fcm_token', 'mobile_type')->first();

            // get user reciever
            $user_receiver = User::where('id', $order->cust_id)->select('id', 'name')->first();
        } else {
            // cancel by user
            // get user sender
            $user_sender = User::where('id', $order->cust_id)->select('id', 'name')->first();
            // get admin
            $user_receiver = User::where('isadmin', 1)->select('id', 'name','fcm_token', 'mobile_type')->first();

        }

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_calnceled', ['order_code' => $order->id]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.sorry');
            $msg['body'] = $body;
            $msg['order_status'] = 5;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'sorry';
            $data['data'] = 'order_calnceled';
            $data['order_status'] = 5;
            $data['params'] = ['order_code' => $order->id];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

   

    public function notifyFcm($user, $data)
    {

        $validate = $this->validateFcmSend($user, $data);
        if ($validate !== true) {
            return $validate;
        }

        return $this->sendFcm($user->mobile_type, $user->fcm_token, $data);

    }

    public function validateFcmSend($user, $data)
    {

        if (!$user) {
            return 'Select User';
        }

        if (!$user->fcm_token) {
            return 'Token Not Found';
        }

        if (!$user->mobile_type) {
            return 'No Mobile Type Found';
        }

        return true;

    }

    public function store($data)
    {
        // store notification in db
       $notification= Notification::Create($data);
       if(isset($data['created_at'])){
        $notification->created_at=$data['created_at'];
         $notification->save();
        return $notification->id;
       }
       return $notification->id;
    }

    

    public function change_locale($id)
    {
        $locale = 'ar';

        if ($locale) {
            app()->setLocale($locale);
        } 
    }

}
