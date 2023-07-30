@extends('layouts.admin')
@section('title','تفاصيل الكتاب')

@section('content')
        <!--==================================*
                   Main Section
        *====================================-->
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">
                               تفاصيل الكتاب</h5>
                        </div>
                       
                    </div>
                </div>
            </div>
          
            <div class="row">
                <!-- Progress Table start -->
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                           <div class="writer-profile">
                               @if($Content[0]->img!='')
                               <img src="{{$Content[0]->img}}" class="mb-3">
                               @else
                               <img src="/defaultuser.png" class="mb-3">
@endif
                               <h5 class="text-dark font-weight-bold mb-10"><a href="#">{{$Content[0]->name}} </a></h5>
                               <p class="mb-0 text-orange font-md"> {{$Content[0]->writer_name}} </p>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 stretched_card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-left w-100">
                                    <h5 class="font-md"> التفاصيل</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->details}}</p>
                                </div>
                                
                            </div><div class="d-flex align-items-center justify-content-between">
                                <div class="text-left w-50">
                                    <h5 class="font-md"> القسم</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->cat_name}}</p>
                                </div>
                                <div class="text-left w-50">
                                    <h5 class="font-md">القسم الفرعي</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->subcat_name}}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="text-left w-50">
                                    <h5 class="font-md">السعر</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->price}}</p>
                                </div>
                                <div class="text-left w-50">
                                    <h5 class="font-md">الكمية</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->quantity}}</span></p>
                                </div>
                            </div>
                         
                            <div class="d-flex align-items-center justify-content-between mt-4">
                            <div class="text-left w-50">
                                    <h5 class="font-md">المدينة</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->city_name}} - <span>المملكة العربية السعودية</span></p>
                                </div>
                                <div class="text-left w-50">
                                    <h5 class="font-md">العنوان</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->address}}</p>
                                </div>
                            </div>
                         
                           
                        </div>
                    </div>
                </div>
              

               
            </div>

            <div class="row">
                <div class="col-12 mt-4">
                    <h5 class="font-weight-bold mb-4">المشتريات</h5>
                    <div class="card">
                        <div class="card-body">
                          
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th scope="col">رقم الطلب</th>
                                            <th scope="col"> إسم العميل</th>
                                            <th scope="col">التاريخ</th>
                                            <th scope="col">الحاله</th>
                                            <th scope="col">السعر</th>
                                            <th scope="col">العناصر</th>
                                            <th scope="col">الاجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $singleorder)
                                        <tr>
                                           
                                            <td>#{{$singleorder->order_id}}</td>
                                            <td>#{{$singleorder->cust_name}}</td>
                                            <td>{{$singleorder->order_date}}</td>
                                            <td><span class="text-blue">
                                                @if($singleorder->status=='0')
                                                لم يدفع
                                                @elseif($singleorder->status=='1')
                                                لم يصل بعد
                                                @else
                                                تم التسليم
                                                @endif
                                            </span></td>
                                            <td>{{$singleorder->price}} <span>ر.س</span></td>
                                            <td>{{$singleorder->quantity}}<span></span></td>
                                            <td>
                                                <ul class="d-flex p-0">
                                                    <!-- <li class="mr-3"><a href="/orders/order_details/{{$singleorder->order_id}}" class="btn-icon btn-inverse-info"><i class="feather ft-eye"></i></a></li> -->
                                                   <!-- <li class="mr-3"><button type="button" class="btn-icon btn-inverse-sucess"><i class="ti-pencil"></i></button></li>
                                                    <li><button type="button" class="btn-icon btn-inverse-danger"><i class="feather ft-download"></i></button></li>-->
                                                    <a href="/orders/order_details/{{$singleorder->order_id}}" >
                                                    <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                        <span class="fas fa-edit "></span> تعديل
                                                    </span>
							                    </a>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
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
