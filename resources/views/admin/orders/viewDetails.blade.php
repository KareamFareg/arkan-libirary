@extends('layouts.admin')
@section('title','عرض التفاصيل')
@section('content')
   <!--==================================*
                   Main Section
        *====================================-->
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">تفاصيل الطلب</h5>
                           
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-7">
                    <div class="card">
                        <h2 class="title-order">موظف الطلب<i class="ft-plus-circle feather"></i></h2>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-center d-grid">
                                    <small class="font-sm text-gray mb-2">رقم الطلب #</small>
                                    <p class="mb-0">{{$data[0]->order_id}}</p>
                                </div>
                                <div class="text-center d-grid">
                                    <small class="font-sm text-gray mb-2"><i class="ft-calendar feather pr-2"></i>تاريخ الطلب</small>
                                    <p class="mb-0">{{$data[0]->order_date}}</p>
                                </div>
                                <div class="text-center d-grid">
                                    <small class="font-sm text-gray mb-2"><i class="ft-calendar feather pr-2"></i>تاريخ الطلب</small>
                                   <a href="#" class="btn font-sm btn-orange text-white border-radius-20">بانتظار المراجعة</a>
                                </div>

                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <small class="font-sm text-gray pr-3"><i class="ft-calendar feather pr-2"></i>الوسم</small>
                                <a href="#" class="btn font-sm btn-orange text-white border-radius-20">إضافة اسم</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
          
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="stretched_card">
                        <div class="card mt-3">
                            <div class="card-header bg_gray">
                                <h5 class="font-md mb-0">العميل</h5>
                            </div>
                            <div class="single-order">
                                <h5 class="font-md font-weight-bold">{{$data[0]->customer_name}}</h5>
                               <div class="d-flex align-items-center justify-content-between">
                                  <p class="mb-0 text-orange">{{$data[0]->customer_phone}}</p>
                                  <a href="#" class="btn btn-orange font-sm text-white border-radius-20"><i class="pr-1 ft-phone-call feather"></i>اتصال</a>
                               </div>
    
                               <div class="d-flex align-items-center justify-content-between">
                                  <div class="w-50 text-left mt-3">
                                      <a href="https://api.whatsapp.com/send?phone={{$data[0]->customer_phone}}" class="text-orange"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="pr-1 bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                      </svg>واتس اب</a>
                                   </div>
                                   <div class="w-50 text-right mt-3">
                                    <a href="#" class="text-orange"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="pr-1 bi bi-chat-left-text" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                      </svg>رسالة نصاية</a>
                                 </div>
                                
    
                               </div>
                               <div class="d-flex align-items-center justify-content-between">
                               <div class="w-50 text-left mt-3">
                                  <a href="#" class="text-orange"><span class="pr-1">{{$data[0]->customer_email}}</span></a>
                               </div>
                             </div>
    
                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stretched_card">
                        <div class="card mt-3">
                            <div class="card-header bg_gray">
                                <h5 class="font-md mb-0">الشحن</h5>
                            </div>
                            <div class="single-order">
                                <h5 class="font-md font-weight-bold"> السعودية</h5>
                                <small>{{$data[0]->customer_address}}</small>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="col-md-4">
                    <div class="stretched_card">
                        <div class="card mt-3">
                            <div class="card-header bg_gray">
                                <h5 class="font-md mb-0">الدفع</h5>
                            </div>
                            <div class="single-order">
                                <h5 class="font-md font-weight-bold"><i class="icon-wallet pr-1"></i>الدفع عند الاستلام</h5>
                            </div>
                        </div>
                    </div>
                 
                </div>
             

            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg_gray">
                            <h5 class="font-md mb-0">المنتجات</h5> 
                        </div>
                        <div class="table-products">
                            <div class="table-responsive">
                                <table class="table text-center mb-0">
                                    <thead class="text-uppercase border-bottom">
                                    <tr>
                                        <th scope="col" style="width: 70%" class="text-gray font-md">المنتج</th>
                                        <th scope="col" class="text-gray font-sm">الكمية</th>
                                        <th scope="col" class="text-gray font-sm">السعر</th>
                                        <th scope="col" class="text-gray font-sm">المجموع</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $singledata)
                                        <?php $total=0;
                                        $sumqun=0;?>
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($singledata->product_img!='')
                                                <img src="{{$singledata->product_img}}" class="img-product">
                                                @else
                                                <img src="/defaultuser.png" class="img-product">
                                                @endif
                                                <a href="#" class="font-weight-bold"> {{$singledata->product_name}}</a>
                                            </div>

                                        </td>
                                        <td>{{$singledata->quantity}}</td>
                                        <td>{{$singledata->price}}<span>ر.س</span></td>

                                        <td><?php

                                       $sum=$singledata->price*$singledata->quantity;
                                       $total=$total+$sum;
                                       $sumqun=$sumqun+$singledata->quantity;
                                         echo $sum; ?><span>ر.س</span></td>
                                       
                                    </tr>
                             @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="border-bottom d-flex table-footer align-items-center justify-content-between">
                                <p class="mb-0 font-md">مجموعة السلة</p>
                                <p class="mb-0 font-md">{{$sumqun}}<span>عنصر</span></p>
                            </div>
                            <!--<div class="border-bottom d-flex table-footer align-items-center justify-content-between">
                                <p class="mb-0 font-md">الشحن</p>
                                <p class="mb-0 font-md">340<span>ر.س</span></p>
                            </div>
                            <div class="border-bottom d-flex table-footer align-items-center justify-content-between">
                                <p class="mb-0 font-md">عمولة الدفع عند الاستلام</p>
                                <p class="mb-0 font-md">340<span>ر.س</span></p>
                            </div>-->
                            <div class="d-flex table-footer align-items-center justify-content-between">
                                <p class="mb-0 font-md"> اجمالى السعر</p>
                                <p class="mb-0 font-md text-orange">{{$total}}<span>ر.س</span></p>
                            </div>


                        </div>
                        <a href="#" class="text-orange title-print"><i class="ft-printer feather"></i><span>طباعة الفاتورة</span></a>
                    </div>

                </div>
            </div>

           <!-- <div class="row mt-8">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg_gray d-flex align-items-center justify-content-between">
                            <h5 class="font-md mb-0"><i class="ft-list feather pr-1"></i>سجل الطلب</h5> 
                            <a href="#" class="btn border-radius-20 btn-orange text-white font-sm p-2"><i class="ti-comments"></i>أضافة تعليق</a>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between border-bottom ptb-10">
                                <div class="d-flex align-items-center">
                                    <small class="d-grid text-center text-gray"><i class="ti-alarm-clock mb-1"></i>بانتظار المراجعة</small>
                                    <h5 class="text-gray mb-0 font-md pl-5">محمد سيد احمد الحاجرى</h5>
                                </div>
                                <small>منذ 4 ايام</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom ptb-10">
                                <div class="d-flex align-items-center">
                                    <small class="d-grid text-center text-gray"><i class="ti-alarm-clock mb-1"></i>بانتظار المراجعة</small>
                                    <h5 class="text-gray mb-0 font-md pl-5">محمد سيد احمد الحاجرى</h5>
                                </div>
                                <small>منذ 4 ايام</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom ptb-10">
                                <div class="d-flex align-items-center">
                                    <small class="d-grid text-center text-gray"><i class="ti-alarm-clock mb-1"></i>بانتظار المراجعة</small>
                                    <h5 class="text-gray mb-0 font-md pl-5">محمد سيد احمد الحاجرى</h5>
                                </div>
                                <small>منذ 4 ايام</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mt-4">
                                <a href="#" class="mr-4 btn btn-orange-2 border-radius-20 d-flex align-items-center text-white text-center"><i class="ti-pencil pr-2"></i>تعديل الطلب</a>
                                <a href="#" class="btn btn-red border-radius-20 d-flex align-items-center text-white text-center"><i class="ti-close pr-2"></i>حذف الطلب</a>

                            </div>
                        </div>
                      
                    </div>

                </div>
            </div>-->
            
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
@endsection

