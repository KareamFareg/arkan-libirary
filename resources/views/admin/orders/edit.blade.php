@extends('layouts.admin')
@section('title','تعديل خدمة ')

@section('extracss')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/plugins/forms/form-quill-editor.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script type="text/javascript">
  tinymce.init({
    selector: '#textareaar',
    directionality: "rtl"
  });

 tinymce.init({
    selector: '#textareaen'
  });
  </script>

@endsection
@section('content')
<div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Blog Edit -->
                <div class="blog-edit-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
          
                                    <!-- Form -->
                                    <form action="/service/update" class="mt-2" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-2">
                                                    <label for="name">العنوان</label>
                                                    <input type="text" id="name" class="form-control" name="name" value="{{$service[0]->name}}"  required/>
                                                    <input type="HIDDEN" id="id" class="form-control" name="id" value="{{$service[0]->id}}"  required/>
                                                </div>
                                            </div> 
                                            <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="price">السعر</label>
                                                <input type="text" id="price" class="form-control" name="price" value="{{$service[0]->price}}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="icon">الايكون</label>
                                                <input type="text" id="icon" class="form-control" name="icon" value="{{$service[0]->icon}}" required />
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="type">نوع الخدمه</label>
                                                <select name="type" class="form-control" id="exampleFormControlSelect2">
                                                    @if($service[0]->type=='1')
                                                    <option value="1" selected>خدمات الشركه</option>
                                                    <option value="2">خدمتنا</option> 
                                                    @else
                                                    <option value="1" >خدمات الشركه</option>
                                                    <option value="2" selected>خدمتنا</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group mb-2">
                                                <label for="TitleAr">التفاصيل</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="details" rows="3" required>{{$service[0]->details}}</textarea>
                                            </div>
                                        </div>
                        
                                            <div class="col-12 mt-50">
                                                <input type="submit" class="btn btn-primary mr-1" value="حفظ">
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Blog Edit -->

            </div>
        </div>
    </div>



@endsection



@section('extrajs')


    <!-- BEGIN: Vendor JS-->
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>

    <!-- END: Page JS-->


    
@endsection