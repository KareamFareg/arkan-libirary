@extends('layouts.admin')
@section('title','مكتبه')

@section('content')
        <!--==================================*
                   Main Section
        *====================================-->
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold"> @if($Content[0]->type==3)
                                العملاء       
                                                     @elseif($Content[0]->type=='1')
                            اضافة مكتبه جديده
                             @elseif($Content[0]->type=='2')
                             دور النشر 
                              @else 
                                 الكاتب 
                             @endif</h5>
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
                               <p class="mb-0 text-orange font-md"> {{$Content[0]->job}} </p>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 stretched_card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-left w-50">
                                    <h5 class="font-md">البريد الالكترونى</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->email}}</p>
                                </div>
                                <div class="text-left w-50">
                                    <h5 class="font-md">رقم الجوال</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->phone}}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="text-left w-50">
                                    <h5 class="font-md">الدولة</h5>
                                    <p class="mb-0 font-md">المملكة العربية السعودية</p>
                                </div>
                                <div class="text-left w-50">
                                    <h5 class="font-md">المدينة</h5>
                                    <p class="mb-0 font-md">{{$cityname}} - <span>المملكة العربية السعودية</span></p>
                                </div>
                            </div>
                         
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="text-left w-100">
                                    <h5 class="font-md">العنوان</h5>
                                    <p class="mb-0 font-md">{{$Content[0]->address}}</p>
                                </div>
                            </div>
                         
                           
                        </div>
                    </div>
                </div>
              

               
            </div>

            <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>الكتب</h4>
                            <div class="d-flex list_books">
                                @foreach($orders as $singleorder)
                                <div class="text-center single-book">
                                    @if($singleorder->img!='')
                                    <img src="/{{$singleorder->img}}">
                                    @else
                                    <img src="/defaultuser.png">
                                    @endif
                                    <h4 class="mb-0 font-md font-weight-bold"><a href="#">{{$singleorder->name}}</a></h4>
                                    <p class="mb-0 text-orange font-md">{{$Content[0]->name}}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
        @endsection
