@extends('layouts.admin')
@section('title','تعديل عميل جديد')
@section('extra')
<script type="text/javascript">
       function getsubcatdata()
{

var val = document.getElementById("cat").value;
	$.ajax({
     type: 'get',
     url: '/dashboard/getsubcat/'+val,
     data: {
     },
     success: function (response) {
       document.getElementById("subcat").innerHTML=response; 
     }
   });
}
function getCitydata()
{

var val = document.getElementById("country_id").value;
	$.ajax({
     type: 'get',
     url: '/dashboard/getcitybyid/'+val,
     data: {
     },
     success: function (response) {
       document.getElementById("city").innerHTML=response; 
     }
   });
}
</script>

@endsection
@section('content')
<div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">
                                
                                @if($type==3)
                                العملاء       
                            @elseif($type=='1')
                             مكتبه جديده
                             @elseif($type=='2')
                             دور النشر 
                              @else 
                                 الكاتب 
                             @endif
                            </h5>
                           
                        </div>
                       
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <h4 class="card_title">
                            @if($type==3)
                                تعديل عميل جديد
                            @elseif($type=='1')
                            تعديل مكتبه جديده
                             @elseif($type=='2')
                            تعديل دور نشر جديده
                              @else 
                               تعديل  كاتب جديد
                             @endif
</h4>
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                   <li> <small class="help">الأسم مملوك لشخص اخر </small> </li>
                    @endforeach
                </ul>
            </div>
            @endif
                            <form action="/dashboard/customer/update" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="validationCustom01">الاسم بالكامل</label>
                                        @if($type!=4)
                                        <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="الاسم بالكامل" value="{{$content[0]->name}}" required="">
                                        <input type="Hidden" name="type" value="{{$type}}" class="form-control" id="validationCustom01" placeholder="" required="">
                                        <input type="Hidden" name="id" value="{{$content[0]->id}}" class="form-control" id="validationCustom01" placeholder="" required="">
                                       @else
                                       <input type="text" class="form-control" name="name" list="name" value="{{$content[0]->name}}"/>
                                            <datalist id="name">
                                            @foreach($writer as $singlewriter)
                                                <option value="{{$singlewriter->name}}">{{$singlewriter->name}}</option>
                                              @endforeach
                                            </datalist>
                                            <input type="Hidden" name="type" value="{{$type}}" class="form-control" id="validationCustom01" placeholder="" required="">
                                            <input type="Hidden" name="id" value="{{$content[0]->id}}" class="form-control" id="validationCustom01" placeholder="" required="">

                                       @endif
                                    </div>
                                    </div>
                                    @if($type!=4)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">الدوله</label>
                                            <select name="country_id" id="country_id"  class="form-control" required>
                                                <option value="">اختر الدوله</option>
                                                @foreach($countries as $singlecountry)
                                                @if($content[0]->country_id==$singlecountry->id)
                                                <option value="{{$singlecountry->id}}" selected>{{$singlecountry->country_arName}}</option>
                                                @else
                                                <option value="{{$singlecountry->id}}">{{$singlecountry->country_arName}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                   <!-- onchange="getCitydata()"<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">المدينة</label>
                                            <select name="city" class="form-control" required>
                                                <option value="">اختر المدينه</option>
                                                @foreach($city as $singlecity)
                                                @if($content[0]->city==$singlecity->id)
                                                <option value="{{$singlecity->id}}" selected>{{$singlecity->name}}</option>
                                                @else
                                                <option value="{{$singlecity->id}}" >{{$singlecity->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="phone">رقم الهاتف</label>
                                         <input type="text" class="form-control" id="phone" name="phone" value="{{$content[0]->phone}}" placeholder="رقم الهاتف " required="">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">الايميل</label>
                                         <input type="email" class="form-control" id="email" name="email" value="{{$content[0]->email}}" placeholder="البريد الالكتروني " required="">
                                        </div>
                                     </div>
                                 
                                    @endif
                                    @if($type==4)
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الرئيسي</label>
                                            <select name="cat" id="cat" onchange="getsubcatdata()" class="form-control" required>
                                                <option value="">اختر القسم الرئيسي</option>
                                                @foreach($cats as $singlecat)
                                                @if($content[0]->cat==$singlecat->id)
                                                <option value="{{$singlecat->id}}" selected>{{$singlecat->name}}</option>
                                                @else
                                                <option value="{{$singlecat->id}}">{{$singlecat->name}}</option>
                                               @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  <!-- <div class="col-md-6">
                                   onchange="getsubcatdata()"
                                        <div class="form-group">
                                            <label class="">القسم الفرعي</label>
                                            <select name="subcat" id="subcat" class="form-control" required>
                                                <option value="">اختر القسم الفرعي</option>
                                                @foreach($subcats as $singlesubcat)
                                                @if($content[0]->subcat==$singlesubcat->id)
                                                <option value="{{$singlesubcat->id}}" selected>{{$singlesubcat->name}}</option>
                                                @else
                                                <option value="{{$singlesubcat->id}}">{{$singlesubcat->name}}</option>
                                               @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>-->
                                    @endif

                                    
                                    
                                 
                                </div>
                                
                              
                               <div class="mt-4 text-right">
                                <button class="btn btn-primary" type="submit">
                                    @if($type==3)
                                تعديل عميل 
                            @elseif($type=='1')
                            تعديل مكتبه 
                             @elseif($type=='2')
                            تعديل دور نشر 
                              @else 
                               تعديل  كاتب 
                             @endif
                                </button>
                               </div>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
            
        
            
        </div>
        @endsection
      