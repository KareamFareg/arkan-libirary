@extends('layouts.admin')
@section('title','عرض العملاء')

@section('content')

        <!--==================================*
                   Main Section
        *====================================-->
        <div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold"> @if($id==3)
                                العملاء       
                                                     @elseif($id=='1')
                            اضافة مكتبه جديده
                             @elseif($id=='2')
                             دور النشر 
                              @else 
                                 الكاتب 
                             @endif</h5>
                           
                        </div>
                        <div class="col-12 col-lg-4 p-2 text-lg-end">
                                <a href="/customer/add/{{$id}}">
                                <span class="btn btn-primary"><span class="fas fa-plus">
                                 @if($id==3)
                                اضافة عميل جديد
                            @elseif($id=='1')
                            اضافة مكتبه جديده
                             @elseif($id=='2')
                            اضافة دور نشر جديده
                              @else 
                               اضافة  كاتب جديد
                             @endif</a>
				        </div>
                      
                    </div>
                </div>
            </div>
          
            <div class="row">
                <!-- Progress Table start -->
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            @if($id == '1')
                                <form action="/customer/search/1" method="post" class="border p-10 border-radius-10 mb-4">
                                @csrf
                                <button  type="submit"><i class="ti-search"></i></button>
                                    <input type="text" name="search" placeholder="البحث في المكتبات" required="" style="padding:7px;">
                                </form>
                            @elseif($id =='2')  
                                <form action="/customer/search/2" method="post" class="border p-10 border-radius-10 mb-4">
                                @csrf
                                <button  type="submit"><i class="ti-search"></i></button>
                                    <input type="text" name="search" placeholder="البحث في دور النشر" required="" style="padding:7px;">
                                </form>
                            @elseif($id =='3')  
                                <form action="/customer/search/3" method="post" class="border p-10 border-radius-10 mb-4">
                                @csrf
                                <button  type="submit"><i class="ti-search"></i></button>
                                    <input type="text" name="search"  placeholder="البحث في العملاء" required="" style="padding:7px;">
                                </form>
                            @else
                                <form action="/customer/search/4" method="post" class="border p-10 border-radius-10 mb-4">
                                @csrf
                                <button  type="submit"><i class="ti-search"></i></button>
                                    <input type="text" name="search" placeholder="البحث عن كاتب" required="" style="padding:7px;">
                                </form>
                            @endif
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th scope="col">الاسم </th>
                                            @if($id==4)
                                            <th scope="col">القسم الرئيسي </th>
                                            <!--<th scope="col">القسم الفرعي </th>-->
                                            @else
                                            <th scope="col">البريد الإلكتورني</th>
                                            <th scope="col">الهاتف</th>
                                            @endif

                                            <!--<th scope="col">المشتريات</th>-->
                                            <th scope="col">الخيارات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Content as $singlecont)
                                        <tr>
                                           
                                            <td>{{$singlecont->name}}</td>
                                            @if($id==4)
                                           <td>{{$singlecont->subcat}}</td>
                                           @else
                                            <td>{{$singlecont->email}}</td>
                                            <td>{{$singlecont->phone}}</td>
                                            @endif

                                            <!--<td>كتب لشيخ ابن جبرين</td>-->
                                            <td>
                                                <a href="/customer/viewsingle/{{$singlecont->id}}">
                                                    <span class="btn btn-outline-primary btn-sm font-small mx-1">
                                                        <span class="fal fa-key "></span> عرض
                                                    </span>
                                                </a>
                                                <a href="/customer/edit/{{$singlecont->id}}">
                                                    <span class="btn btn-outline-primary btn-sm font-small mx-1">
                                                        <span class="fal fa-key "></span> تعديل
                                                    </span>
                                                </a>
                                                
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
                <!-- Progress Table end -->
            </div>
            
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
    


@endsection

