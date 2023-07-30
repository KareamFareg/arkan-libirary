@extends('layouts.admin')
@section('title','عرض الكتب')

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
                            الكتب</h5>
                           
                        </div>
                        @can('ebooks-create')
                        <div class="col-12 col-lg-4 p-2 text-lg-end">
                                <a href="/ebooks/add">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> إضافة  جديد</span>
                                </a>
				        </div>
                        @endcan
                    </div>
                </div>
            </div>
          
            <div class="row">
                <!-- Progress Table start -->
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                          
                            <form action="/ebooks/search" method="post" class="border p-10 border-radius-10 mb-4">
                            @csrf
                            <button  type="submit"><i class="ti-search"></i></button>
                                <input type="text" name="search" placeholder="البحث في الكتب" required="">
                            </form>

                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th scope="col">الاسم </th>
                                            <th scope="col">إسم الكاتب </th>
                                            <th scope="col">القسم الرئيسي </th>
                                            <th scope="col">القسم الفرعي </th>
                                            <th scope="col"> عدد الاجزاء </th>
                                            <th scope="col"> السعر </th>
                                            <th scope="col">صوره الكتاب</th>
                                            <th scope="col">رفع بواسطه</th>
                                            <th scope="col">الخيارات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Content as $singlecont)
                                        <tr>
                                           
                                        <td>{{$singlecont->name}}</td>
                                            <td>{{$singlecont->writer_name}}</td>
                                            <td>{{$singlecont->cat_name}}</td>
                                            <td>{{$singlecont->subcat_name}}</td>
                                            <td>{{$singlecont->pages}}</td>
                                            @if($singlecont->price != 0)
                                               <td>{{$singlecont->price}}</td>
                                            @else 
                                              <td>مجانا</td>
                                            @endif
                                            <td><img src="{{$singlecont->image}}" width="50px" height="50px"/></td>
                                            <td>{{$singlecont->user_name}}</td>
                                            <td>
                                                <ul class="d-flex p-0">
                                                @can('ebooks-read')
                                                    <a href="/ebooks/viewsingle/{{$singlecont->id}}" >
                                                        <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                            <span class="fas fa-search "></span> عرض
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('ebooks-update')
                                                    <a href="/ebooks/featuredEbooks/{{$singlecont->id}}/1" >
                                                        <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                            <span class="fas fa-star "></span> المفضله
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('ebooks-update')
                                                    <a href="/ebooks/edit/{{$singlecont->id}}" >
                                                        <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                            <span class="fas fa-edit "></span> تعديل
                                                        </span>
                                                    </a>
                                                @endcan
                                                @can('ebooks-delete')
                                                    <a href="/ebooks/delete/{{$singlecont->id}}" >
                                                        <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                            <span class="fas fa-delete "></span> حذف
                                                        </span>
                                                    </a>
                                                @endcan
                                                    <!-- <li class="mr-3"><a href="/ebooks/viewsingle/{{$singlecont->id}}" class="btn-icon btn-inverse-info"><i class="feather ft-eye"></i></a></li>
                                                    <li class="mr-3"><a href="/ebooks/featuredEbooks/{{$singlecont->id}}/1" class="btn-icon btn-inverse-info"><i class="feather ft-star"></i></a></li>
                                                    <li class="mr-3"><a href="/ebooks/edit/{{$singlecont->id}}" class="btn-icon btn-inverse-sucess"><i class="ti-pencil"></i></a></li>
                                                    <li class="mr-3"><a href="/ebooks/delete/{{$singlecont->id}}" class="btn-icon btn-delete"><i class="ti-pencil" style="color:red" ></i></a></li> -->
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
                <!-- Progress Table end -->
            </div>
            
        
            
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
    


@endsection

