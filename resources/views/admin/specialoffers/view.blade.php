@extends('layouts.admin')
@section('title',' العروض الخاصه
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
                            <h5 class="mr-4 mb-0 font-weight-bold"> العروض الخاصه</h5>
                           
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
                               <h3 class="font-md mb-0 font-weight-900"> العروض الخاصة التخفيض</h3>
                               <span class="font-md pl-2">(عرض واحد)</span>
                           </div>
                        </div>
                      <div class="card-body">
                           <div class="list_offers">
                               @foreach($offers as $soffers)
                               <div class="item">
                                 <div class="d-flex align-items-center justify-content-between mb-2">
                                     <h5 class="font-md"><a href="#" class="text-orange">{{$soffers->name}}</a></h5>
                                     <div class="d-flex align-items-center">
                                         <p class="text-orange mb-0 pr-4"><i class="ti-bar-chart pr-2"></i>الاحصائيات</p>
                                         <div class="custom-control custom-switch custom-switch-sm">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                            <label class="custom-control-label" for="customSwitch2"></label>
                                          </div>
                                     </div>
                                 </div>
                                 <p class="mb-0 text-gray">{{$soffers->details}}</p>
                                 <small class="text-gray"><i class="ft-calendar feather pr-2"></i>ينتهي بتاريخ: {{$soffers->expiredate}}</small>
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

