@extends('layouts.admin')
@section('scripts')
<script type="text/javascript">
       function getsubcatdata()
{

var val = document.getElementById("cat").value;
	$.ajax({
     type: 'get',
     url: '/getsubcat/'+val,
     data: {
     },
     success: function (response) {
       document.getElementById("subcat").innerHTML=response; 
     }
   });
}
$(function() {
  $('.selectpicker').selectpicker();
});
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" >-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" />  -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<style>
    select{
        padding:10px !important;
        border:none  !important;
    }
</style>

@endsection
@section('content')
<div class="col-12 p-3">
		<!-- breadcrumb -->
		<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => 'لوحة التحكم' , 'isactive' => false],
			['url' => route('admin.users.index') , 'title' => 'المستخدمين' , 'isactive' => false],
			['url' => '#' , 'title' =>  'اضافة مستخدم', 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->

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
                            <form action="/ebooks/update/{{$ebook->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="validationCustom01">عنوان الكتاب </label>
                                        <input type="text" name="name" class="form-control" id="validationCustom01" value="{{$ebook->name}}" placeholder=" عنوان الكتاب" required="">
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="writer_name"> اسم الكاتب </label>
                                        <input type="text" name="writer_name" class="form-control" id="writer_name" placeholder="اسم الكاتب " required="">
                                       </div>
                                    </div> -->
  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""> المؤلف</label>
                                            <select class="form-control selectpicker" id="select-country"  name="writer_name" data-live-search="true" style="padding:2px!important">
												@foreach($writer as $singlewriter)
													@if($ebook->writer_name==$singlewriter->id)
													<option data-tokens="{{$singlewriter->name}}" value="{{$singlewriter->id}}" selected>{{$singlewriter->name}}</option>
													@else
													<option data-tokens="{{$singlewriter->name}}" value="{{$singlewriter->id}}" >{{$singlewriter->name}}</option>
													@endif                                               
                                                @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الرئيسي</label>
                                            <select style="padding:2px!important" name="cat" id="cat"  class="form-control"  onchange="getsubcatdata()" required>
                                                <option value="">اختر القسم الرئيسي</option>
												@foreach($cats as $singlecat)
													@if($ebook->cat_id==$singlecat->id)
													<option value="{{$singlecat->id}}" selected>{{$singlecat->name}}</option>
													@else
													<option value="{{$singlecat->id}}">{{$singlecat->name}}</option>
												@endif                                                
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  
                                     
                                       <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الفرعي</label>
                                            <select style="padding:2px!important" name="subcat" id="subcat" class="form-control" >
                                                <option value="">اختر القسم الفرعي</option>
												@foreach($subcats as $singlesubcat)
                                                @if($ebook->subcat_id==$singlesubcat->id)
                                                <option value="{{$singlesubcat->id}}" selected>{{$singlesubcat->name}}</option>
                                                @else
                                                <option value="{{$singlesubcat->id}}">{{$singlesubcat->name}}</option>
                                               @endif
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">السعر</label>
                                         <input type="number" class="form-control" id="price" step="0.1" name="price" value="{{$ebook->price}}" required="">
                                        </div>
                                     </div>     
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="parts">عدد الأجزاء</label>
                                         <input type="number" class="form-control" id="parts" step="1" name="parts" value="{{$ebook->parts}}" required="">
                                        </div>
                                     </div>     
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="pages">عدد الصفحات</label>
                                         <input type="number" class="form-control" id="pages" step="1" name="pages" value="{{$ebook->pages}}" required="">
                                        </div>
                                     </div>     
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="language">اللغه</label>
                                         <input type="text" class="form-control" id="language"  name="language" value="{{$ebook->language}}" required="">
                                        </div>
                                     </div>     
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">الخصم</label>
                                         <input type="number" class="form-control" id="discount" step="1" value="0" value="{{$ebook->discount}}" name="discount" required="">
                                        </div>
                                     </div>                                    
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                         <label for="phone">نبذة عن الكتاب</label>
                                         <textarea class="form-control" id="details" name="details" value="{{$ebook->details}}">{{$ebook->details}}</textarea>
                                        </div>
                                     </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                         <label for="phone">رفع صورة الكتاب</label>
                                         <input type="file" class="form-control" id="image" name="image"/>
                                        </div>
                                     </div>
                                     
                                     <div class="col-md-12">
                                        <div class="form-group">
                                         <label for="file">رفع ملف الكتاب</label>
                                         <input type="file" class="form-control" id="file" name="file"/>
                                        </div>
                                     </div>
                                </div>
		 
		<div class="col-12 p-3">
			<button class="btn btn-success" id="submitEvaluation">حفظ</button>
		</div> 
		</form>
	</div>
</div>
@endsection