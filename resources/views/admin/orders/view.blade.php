@extends('layouts.admin')
@section('title','الطلبات')
@section('style')
 <style>
    .single-order{
        padding:5px;
    }
    </style>
@endsection
@section('content')

<!-- *====================================--> 
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">الطلبات</h5>
                           
                        </div>
                        
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-12 mt-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="current-tab" data-toggle="tab" href="#current" role="tab" aria-controls="current" aria-selected="true">الطلبات الحالية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="finished-tab" data-toggle="tab" href="#finished" role="tab" aria-controls="finished" aria-selected="false"> الطلبات المنتهية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="canceled-tab" data-toggle="tab" href="#canceled" role="tab" aria-controls="canceled" aria-selected="false">الطلبات الملغية</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
                          <div class="row">
                            <h6 style="color:red;padding:10px">الطلبات الحاليه</h6>
                            @foreach($currentorders as $scurrentorders)
                              <div class="col-md-4">
                                  <div class="card mt-3">
                                      <div class="single-order" style=" padding:5px;box-shadow:1px">
                                          <h5 class="font-md font-weight-bold">{{$scurrentorders->cust_name}}</h5>
                                         <div class="">
                                            <small>الطلبات</small>
                                            <?php
                                            $data = DB::select("SELECT *,(SELECT users.name from users WHERE users.id=`customer_id`) as 'customer_name',(SELECT users.phone from users WHERE users.id=`customer_id`) as 'customer_phone',(SELECT users.address from users WHERE users.id=`customer_id`) as 'customer_address',(SELECT users.email from users WHERE users.id=`customer_id`) as 'customer_email',(SELECT products.name from products WHERE products.id=`item_id`)as'product_name',(SELECT products.img from products WHERE products.id=`item_id`)as'product_img' FROM `order_details` WHERE `order_id`='$scurrentorders->id';");
                                            $items='';
                                            foreach($data as $sdata)
                                            {
                                                $items=$items.$sdata->product_name.'-';
                                            }?>
                                            <p>{{rtrim($items, "- ")}}</p>
                                         </div>

                                         <div class="d-flex align-items-center justify-content-between">
                                            <div class="w-50 text-left">
                                                <small>التاريخ</small>
                                                <p>{{$scurrentorders->date}}</p>
                                             </div>
                                            
                                         </div>
                                         @can('orders-update')
                                            <div class="group-btns">
                                                <a href="/orders/accept/1/{{$scurrentorders->id}}" class="text-green btn btn-primary">قبول الطلب</a>
                                                @can('orders-read')
                                                    <a href="/orders/order_details/{{$scurrentorders->id}}" class="text-gray btn btn-danger">عرض الطلب</a>
                                                    <a href="/orders/accept/-1/{{$scurrentorders->id}}" class="text-gray btn btn-danger">رفض</a>
                                                @endcan
                                            </div>
                                        @endcan
                                      </div>
                                  </div>
                              </div>
                     @endforeach
                          

                          </div>
                        </div>
                        <div class="tab-pane " id="finished" role="tabpanel" aria-labelledby="finished-tab">
                        <div class="row">
                        <h6 style="color:red;padding:10px">الطلبات المنتهيه</h6>
                            @foreach($finishedorders as $sfinishedorders)
                              <div class="col-md-4">
                                  <div class="card mt-3">
                                      <div class="single-order"  style=" padding:5px;">
                                          <h5 class="font-md font-weight-bold">{{$sfinishedorders->cust_name}}</h5>
                                         <div class="">
                                            <small>الطلبات</small>
                                            <?php
                                            $fdata = DB::select("SELECT *,(SELECT users.name from users WHERE users.id=`customer_id`) as 'customer_name',(SELECT users.phone from users WHERE users.id=`customer_id`) as 'customer_phone',(SELECT users.address from users WHERE users.id=`customer_id`) as 'customer_address',(SELECT users.email from users WHERE users.id=`customer_id`) as 'customer_email',(SELECT products.name from products WHERE products.id=`item_id`)as'product_name',(SELECT products.img from products WHERE products.id=`item_id`)as'product_img' FROM `order_details` WHERE `order_id`='$sfinishedorders->id';");
                                            $fitems='';
                                            foreach($fdata as $sfdata)
                                            {
                                                $fitems=$fitems.$sfdata->product_name.'-';
                                            }?>
                                            <p>{{rtrim($fitems, "- ")}}</p>
                                         </div>

                                         <div class="d-flex align-items-center justify-content-between">
                                            <div class="w-50 text-left">
                                                <small>التاريخ</small>
                                                <p>{{$sfinishedorders->date}}</p>
                                             </div>
                                            
                                         </div>
                                         @can('orders-read')
                                            <div class="group-btns">
                                                <a href="/orders/order_details/{{$scurrentorders->id}}" class="text-gray btn btn-danger">عرض الطلب</a>
                                            </div>
                                        @endcan
                                      </div>
                                  </div>
                              </div>
                     @endforeach
                          

                          </div>
                        </div>
                        <div class="tab-pane " id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
                        <div class="row">
                        <h6 style="color:red;padding:10px">الطلبات المحذوفه</h6>
                            @foreach($canceledorders as $scanceledorders)
                              <div class="col-md-4">
                                  <div class="card mt-3">
                                      <div class="single-order"  style=" padding:5px;">
                                          <h5 class="font-md font-weight-bold">{{$scanceledorders->cust_name}}</h5>
                                         <div class="">
                                            <small>الطلبات</small>
                                            <?php
                                            $cdata = DB::select("SELECT *,(SELECT users.name from users WHERE users.id=`customer_id`) as 'customer_name',(SELECT users.phone from users WHERE users.id=`customer_id`) as 'customer_phone',(SELECT users.address from users WHERE users.id=`customer_id`) as 'customer_address',(SELECT users.email from users WHERE users.id=`customer_id`) as 'customer_email',(SELECT products.name from products WHERE products.id=`item_id`)as'product_name',(SELECT products.img from products WHERE products.id=`item_id`)as'product_img' FROM `order_details` WHERE `order_id`='$scanceledorders->id';");
                                            $citems='';
                                            foreach($cdata as $scdata)
                                            {
                                                $citems=$citems.$scdata->product_name.'-';
                                            }?>
                                            <p>{{rtrim($citems, "- ")}}</p>
                                         </div>

                                         <div class="d-flex align-items-center justify-content-between">
                                            <div class="w-50 text-left">
                                                <small>التاريخ</small>
                                                <p>{{$scanceledorders->date}}</p>
                                             </div>
                                            
                                         </div>
                                         @can('orders-read')
                                            <div class="group-btns">
                                                <a href="/orders/order_details/{{$scurrentorders->id}}" class="text-gray btn btn-danger">عرض الطلب</a>
                                            </div>
                                        @endcan
                                      </div>
                                  </div>
                              </div>
                     @endforeach
                          

                          </div>    
                    </div>
                    </div>
                </div>
              
            </div>
            
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->


@endsection

