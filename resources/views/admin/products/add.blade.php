@extends('layouts.admin')
@section('title','اضافة كتاب جديد')
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
                                
                               الكتب
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
                         
                                اضافة كتاب جديد
                           
</h4>
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                   <li> <small class="help">{{ $error }}</small> </li>
                    @endforeach
                </ul>
            </div>
            @endif
                            <form action="/dashboard/products/insert" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="validationCustom01">عنوان الكتاب </label>
                                        <input type="text" name="name" class="form-control" id="validationCustom01" placeholder=" عنوان الكتاب" required="">
                                       </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">حاله الكتاب</label>
                                            <select name="status" class="form-control" required>
                                                <option value="">اختر حالة الكتاب</option>
                                                <option value="0">جديد</option>
                                                <option value="1">مستعمل</option>
                                            </select>
                                        </div>
                                    </div> 
                                    @if(Auth::user()->type==2)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""> دور النشر</label>
                                            <input type="Hidden" name="publisher_id" value="{{Auth::user()->id}}" class="form-control" id="validationCustom01" placeholder=" عنوان الكتاب" required="">
        
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""> دور النشر</label>
                                            <select name="publisher_id" class="form-control" required>
                                                <option value="">اختر دور النشر</option>
                                                @foreach($publisher as $singlepublisher)
                                                <option value="{{$singlepublisher->id}}">{{$singlepublisher->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""> المؤلف</label>
                                            <select name="writer_id" class="form-control" required>
                                                <option value="">اختر المؤلف</option>
                                                @foreach($writer as $singlewriter)
                                                <option value="{{$singlewriter->id}}">{{$singlewriter->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الرئيسي</label>
                                            <select name="cat" id="cat"  class="form-control"  onchange="getsubcatdata()" required>
                                                <option value="">اختر القسم الرئيسي</option>
                                                @foreach($cats as $singlecat)
                                                <option value="{{$singlecat->id}}">{{$singlecat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  
                                     
                                       <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الفرعي</label>
                                            <select name="subcat" id="subcat" class="form-control" required>
                                                <option value="">اختر القسم الفرعي</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">الدوله</label>
                                            <select name="country_id" id="country_id" onchange="getCitydata()" class="form-control" required>
                                                <option value="">اختر الدوله</option>
                                                @foreach($countries as $singlecountry)
                                                <option value="{{$singlecountry->id}}">{{$singlecountry->country_arName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">المدينة</label>
                                            <select name="city" id="city" class="form-control" required>
                                                <option value="">اختر المدينه</option>
                                                @foreach($city as $singlecity)
                                                <option value="{{$singlecity->id}}">{{$singlecity->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="validationCustom01">عنوان  </label>
                                        <input type="text" name="address" class="form-control" id="validationCustom01" placeholder=" العنوان" required="">
                                       </div>
                                    </div>
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">السعر</label>
                                         <input type="number" class="form-control" id="price" step="0.1" name="price" required="">
                                        </div>
                                     </div>     
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">الخصم</label>
                                         <input type="number" class="form-control" id="discount" step="1" value="0" name="discount" required="">
                                        </div>
                                     </div>                                    
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">الكمية</label>
                                         <input type="number" class="form-control" id="quantity" step="1" name="quantity" required="">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">عدد الصفحات</label>
                                         <input type="number" class="form-control" id="numpg"  step="1" name="numpg" required="">
                                        </div>
                                     </div> 
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email"> مقاس الكتاب</label>
                                         <input type="text" class="form-control" id="booksize"  name="booksize" required="">
                                        </div>
                                     </div>  
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">تنبيه او ملاحظه</label>
                                         <input type="text" class="form-control" id="notes"  name="notes" >
                                        </div>
                                     </div>
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                         <label for="phone">نبذة عن الكتاب</label>
                                         <textarea class="form-control" id="details" name="details"></textarea>
                                        </div>
                                     </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                         <label for="phone">رفع صورة الكتاب</label>
                                         <input type="file" class="form-control" id="image" name="image"/>
                                        </div>
                                     </div>
                                     
                                 
                                    
                                 
                                </div>
                                
                              
                               <div class="mt-4 text-right">
                                <button class="btn btn-primary" type="submit">
                                اضافة كتاب 
                           
                                </button>
                               </div>
                            </form>
         


                        </div>
                    </div>
                </div>
            </div>
            
        
            
        </div>
        @endsection
      