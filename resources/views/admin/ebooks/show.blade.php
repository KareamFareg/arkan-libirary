@extends('layouts.admin')
@section('content')
{{-- <div class=" p-3">
    <x-bread-crumb :breads="[
        ['url' => url('/admin') , 'title' => 'لوحة التحكم' , 'isactive' => false],
        ['url' => route('admin.users.index') , 'title' => 'المستخدمين' , 'isactive' => false],
        ['url' => '#' , 'title' =>  $user->name, 'isactive' => true],
    ]">
    </x-bread-crumb> 
</div> --}}
<div class="col-12 py-5 rounded-2" style="text-align: center;background: var(--background-1);margin-top: -5px;">
    <div class="col-12" style="display:flex;justify-content: center;">
    <img src="{{$Content[0]->image}}" style="width:130px;height: 130px;border-radius: 50%;">
    </div>
    <div class="col-12 p-2 text-center"  style="overflow:auto;">
        {{$Content[0]->name}}
        <?php $writer = \App\Models\User::find($Content[0]->writer_name);?>
        @if( $writer !== null)
        {{$writer->name}} 
        @else
        الادمن
        @endif
    </div>
</div>
<div class="col-12 py-0 px-3 row">
    <div class="col-12  pt-2" style="min-height: 80vh">
        {{-- <div class="col-12 px-3">
            <h4>المستخدم</h4>
        </div> --}}
        <div class="col-12 col-lg-9 px-3 py-5 d-flex mx-auto justify-content-center align-items-center">
            <div class="col-12 p-0 row justify-content-center">
                <div class="col-12 row p-0">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                        <a href="{{route('admin.ebooks.index')}}" style="color:inherit;">
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1">القسم</h6>
                                    <h6 class="font-3">{{$Content[0]->cat_name}}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                        
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1">القسم الفرعي </h6>
                                    <h6 class="font-3">{{$Content[0]->subcat_name}}</h6>
                                </div>
                            </div>
                      
                    </div>
                  
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                       
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1"> السعر </h6>
                                    @if($Content[0]->price!= 0)
                                      <h6 class="font-3">{{$Content[0]->price}}</h6>
                                    @else 
                                      <h6 class="font-3">مجانا</h6>
                                    @endif
                                    
                                </div>
                            </div>
                      
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                       
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1">الخصم </h6>
                                    <h6 class="font-3">{{$Content[0]->discount}} %</h6>
                                </div>
                            </div>
                       
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                       
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1">عدد الاجزاء</h6>
                                    <h6 class="font-3">{{$Content[0]->parts}}</h6>
                                </div>
                            </div>
                       
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                       
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1"> عدد الصفحات</h6>
                                    <h6 class="font-3">{{$Content[0]->pages}}</h6>
                                </div>
                            </div>
                       
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3  px-2 mb-3">
                            <div class="col-12 px-0 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                <div style="width: 80px;" class="p-2">
                                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                        <span class="fal fa-book font-5"></span>
                                    </div>
                                </div>
                                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                                    <h6 class="font-1"> اللغات</h6>
                                    <h6 class="font-3">{{$Content[0]->language}}</h6>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
