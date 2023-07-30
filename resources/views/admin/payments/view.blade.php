@extends('layouts.admin')
@section('title',' المدفوعات الالكترونية
')

@section('content')

        <!--==================================*
                   Main Section
        *====================================-->
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold"> المدفوعات الالكترونية</h5>
                           
                        </div>
                        <div class="d-flex">
                        
                           
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg_gray d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center">
                               <h3 class="font-md mb-0 font-weight-900"><i class="icon-wallet"></i>المدفوعات الالكترونية</h3>
                               <span class="font-md">(٠ فاتورة) - اجمالي الغير مدفوع ( 0 )</span>
                           </div>
                           <a href="#" class="btn"><i class="icon-lightbulb"></i>سياسية المدفوعات</a>
                        </div>
                        @foreach($payments as $spayment)
                      <div class="card-body">
                           <div class="list_payments">
                               <div class="item d-flex align-items-center justify-content-between">
                                   <p class="mb-0"><img class="img_method" src="/app-assets/images/master.png"><span>{{$spayment->number}}</span></p>
                                   <p class="mb-0">{{$spayment->expiredate}}</p>
                                   <p class="mb-0">{{$spayment->name}}</p>
                               </div>

                           </div>
                      </div>
                      @endforeach
                    </div>
                </div>
            </div>
          
           
           
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
    


@endsection

