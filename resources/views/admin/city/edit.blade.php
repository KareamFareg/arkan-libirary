@extends('layouts.admin')
@section('title','تعديل مدينه جديد')
@section('extra')


@endsection
@section('content')
<div class="main-content-inner">
    <div class="row mb-4">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                    <h5 class="mr-4 mb-0 font-weight-bold">

                        المدن
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

                        تعديل مدينه 

                    </h4>
                    <form action="/dashboard/city/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom01"> اختر الدوله</label>
                                    <select name="country_id" class="form-control" required>
                                                <option value="">اختر الدوله</option>
                                                @foreach($countries as $singlecountries)
                                                @if($content[0]->country_id==$singlecountries->id)
                                                <option value="{{$singlecountries->id}}" selected>{{$singlecountries->country_arName}}</option>
                                                @else
                                                <option value="{{$singlecountries->id}}">{{$singlecountries->country_arName}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom01">الاسم المدينه</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                        placeholder="الاسم المدينه" value="{{$content[0]->name}}" required="">
                                        <input type="HIDDEN" name="id"  value="{{$content[0]->id}}" required="">
                                </div>
                            </div>

                           
                        </div>


                        <div class="mt-4 text-right">
                            <button class="btn btn-primary" type="submit">

                                تعديل مدينه
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



</div>
@endsection