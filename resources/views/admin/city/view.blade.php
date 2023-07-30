@extends('layouts.admin')
@section('title','عرض المدن')

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
                                 المدن 
                             </h5>
                           
                        </div>
                        @can('city-create')
                            <div class="col-12 col-lg-4 p-2 text-lg-end">
                                    <a href="{{route('city.addcity')}}">
                                    <span class="btn btn-primary"><span class="fas fa-plus"></span> إضافة مدينه جديد</span>
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
                          
                            

                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th scope="col">الاسم </th>
                                           
                                            <th scope="col">الخيارات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Content as $singlecont)
                                        <tr>
                                           
                                            <td>{{$singlecont->name}}</td>
                                        @can('city-update')
                                            <td>
                                                <a href="/city/edit/{{$singlecont->id}}">
                                                    <span class="btn  btn-outline-success btn-sm font-small mx-1">
                                                        <span class="fas fa-wrench "></span> تحكم
                                                    </span>
                                                </a>
                                              
                                            </td>
                                        @endcan    
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

