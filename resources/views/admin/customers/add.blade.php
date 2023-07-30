@extends('layouts.admin')
@section('title','اضافة عميل جديد')
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
} function getCitydata()
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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- jsFiddle will insert css and js -->
	<style>

#map {
  height: 500px;
  width: 100%;
}

/* 
 * Optional: Makes the sample page fill the window. 
 */

#description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}

#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

.pac-card {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  font-family: Roboto;
  padding: 0;
}

#pac-container {
  padding-bottom: 12px;
  margin-right: 12px;
}

.pac-controls {
  display: inline-block;
  padding: 5px 11px;
}

.pac-controls label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 400px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}


	</style>
 
<div class="main-content-inner">
            <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">
                                
                                @if($id==3)
                                العملاء       
                                                     @elseif($id=='1')
                            اضافة مكتبه جديده
                             @elseif($id=='2')
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
                            @if($id==3)
                                اضافة عميل جديد
                            @elseif($id=='1')
                            اضافة مكتبه جديده
                             @elseif($id=='2')
                            اضافة دور نشر جديده
                              @else 
                               اضافة  كاتب جديد
                             @endif
</h4>
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                   <li> <small class="help">الأسم موجود من قبل</small> </li>
                    @endforeach
                </ul>
            </div>
            @endif
                            <form action="/dashboard/customer/insert" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                       @if($id!=4)
                                        <label for="validationCustom01">الاسم بالكامل</label>
                                        <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="الاسم بالكامل" required="">
                                        <input type="hidden" name="type" value="{{$id}}" class="form-control" id="validationCustom01" placeholder="" required="">
                                        @else
                                        <label for="validationCustom01">الاسم بالكامل</label>
                                        <input type="text" class="form-control" name="name" list="name" />
                                            <datalist id="name">
                                            @foreach($writer as $singlewriter)
                                                <option value="{{$singlewriter->name}}">{{$singlewriter->name}}</option>
                                              @endforeach
                                            </datalist>
                                            <input type="hidden" name="type" value="{{$id}}" class="form-control" id="validationCustom01" placeholder="" required="">

                                                  <!-- <select class="form-control selectpicker" id="select-country"  name="name" data-live-search="true">
                                                        @foreach($writer as $singlewriter)
                                                            <option  data-tokens="{{$singlewriter->name}}" value="{{$singlewriter->id}}">{{$singlewriter->name}}</option>
                                                         @endforeach
                                                </select> -->
                                        @endif
                                       </div>
                                    </div>
                                    @if($id!=4)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">الدوله</label>
                                            <select name="country_id" id="country_id"  class="form-control" required>
                                                <option value="">اختر الدوله</option>
                                                @foreach($countries as $singlecountry)
                                                <option value="{{$singlecountry->id}}">{{$singlecountry->country_arName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                   <!-- onchange="getCitydata()" <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">المدينة</label>
                                            <select name="city" id="city" class="form-control" required>
                                               
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="phone">رقم الهاتف</label>
                                         <input type="text" class="form-control" id="phone" name="phone" placeholder="رقم الهاتف " required="">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                         <label for="email">الايميل</label>
                                         <input type="email" class="form-control" id="email" name="email" placeholder="البريد الالكتروني " required="">
                                        </div>
                                     </div>
                                    @endif
                                    @if($id==4)
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">القسم الرئيسي</label>
                                            <select name="cat" id="cat"  class="form-control" required>
                                                <option value="">اختر القسم الرئيسي</option>
                                                @foreach($cats as $singlecat)
                                                <option value="{{$singlecat->id}}">{{$singlecat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   <!--<div class="col-md-6" >
                                       onchange="getsubcatdata()"
                                        <div class="form-group">
                                            <label class="">القسم الفرعي</label>
                                            <select name="subcat" id="subcat" class="form-control" required>
                                                <option value="">اختر القسم الفرعي</option>
                                               
                                            </select>
                                        </div>
                                    </div>-->
                                    @endif  
                                    @if($id==1)
                              
                         
                                    <div class="col-md-12" >
                                    <div class="pac-card" id="pac-card">
      <div>
        <div id="title">العنوان</div>
        <div id="type-selector" class="pac-controls" HIDDEN>
          <input
            type="radio"
            name="type1"
            id="changetype-all"
            checked="checked"
          />
          <label for="changetype-all">All</label>

          <input type="radio" name="type1" id="changetype-establishment" />
          <label for="changetype-establishment">establishment</label>

          <input type="radio" name="type1" id="changetype-address" />
          <label for="changetype-address">address</label>

          <input type="radio" name="type1" id="changetype-geocode" />
          <label for="changetype-geocode">geocode</label>

          <input type="radio" name="type1" id="changetype-cities" />
          <label for="changetype-cities">(cities)</label>

          <input type="radio" name="type1" id="changetype-regions" />
          <label for="changetype-regions">(regions)</label>
        </div>
        <br />
        <div id="strict-bounds-selector" class="pac-controls" HIDDEN>
          <input type="checkbox" id="use-location-bias" value="" checked />
          <label for="use-location-bias">Bias to map viewport</label>

          <input type="checkbox" id="use-strict-bounds" value="" />
          <label for="use-strict-bounds">Strict bounds</label>
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" name="address" type="text" placeholder="Enter a location"  />
		<div>
        
            <input type="hidden" id="latitude" name="latitude"  />
      
            <input type="hidden" id="longitude" name="longitude"  />
    </div>
      </div>
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
      <span id="place-name" class="title"></span><br />
      <span id="place-address"></span>
    </div>


    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_Qajj9nMV6UZB_L8cAReXPdXeRoodnc8&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
	  <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

	<script>

function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapTypeControl: false,
  });
  var lp = new locationPicker(document.getElementById("map"), {
    setCurrentPosition: true, // You can omit this, defaults to true
    lat: 45.5017,
    lng: -73.5673
  }, {
    zoom: 15 // You can set any google map options here, zoom defaults to 15
  });
  const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");
  const biasInputElement = document.getElementById("use-location-bias");
  const strictBoundsInputElement = document.getElementById("use-strict-bounds");
  const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ["establishment"],
  };

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  const autocomplete = new google.maps.places.Autocomplete(input, options);


  autocomplete.bindTo("bounds", map);

  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });
   
  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {

      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
  document.getElementById("latitude").value = place.geometry.location.lat();
  document.getElementById("longitude").value = place.geometry.location.lng(); 
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);
  });

 google.maps.event.addListener(lp.map, 'idle', function (event) {
    // Get current location and show it in HTML

    var location = lp.getMarkerPosition();
		      showInfo(lp.getMarkerPosition());

     document.getElementById("latitude").value =  location.lat 
	 document.getElementById("longitude").value=location.lng;
	 document.getElementById("pac-input").value= location.formatted_address;
;
  });
  function setupClickListener(id, types) {
    const radioButton = document.getElementById(id);

    radioButton.addEventListener("click", () => {
      autocomplete.setTypes(types);
      input.value = "";
    });
  }

  setupClickListener("changetype-all", []);
  setupClickListener("changetype-address", ["address"]);
  setupClickListener("changetype-establishment", ["establishment"]);
  setupClickListener("changetype-geocode", ["geocode"]);
  setupClickListener("changetype-cities", ["(cities)"]);
  setupClickListener("changetype-regions", ["(regions)"]);
  biasInputElement.addEventListener("change", () => {
    if (biasInputElement.checked) {
      autocomplete.bindTo("bounds", map);
    } else {

      autocomplete.unbind("bounds");
      autocomplete.setBounds({ east: 180, west: -180, north: 90, south: -90 });
      strictBoundsInputElement.checked = biasInputElement.checked;
    }

    input.value = "";
  });
  strictBoundsInputElement.addEventListener("change", () => {
    autocomplete.setOptions({
      strictBounds: strictBoundsInputElement.checked,
    });
    if (strictBoundsInputElement.checked) {
      biasInputElement.checked = strictBoundsInputElement.checked;
      autocomplete.bindTo("bounds", map);
    }

    input.value = "";
  });
}

window.initMap = initMap;
function showInfo(latlng) {
var geocoder= new google.maps.Geocoder();

      geocoder.geocode({
        'latLng': latlng
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            // here assign the data to asp lables
            document.getElementById('pac-input').value = results[1].formatted_address;
          } else {
            alert('No results found');
          }
        } else {
          alert('Geocoder failed due to: ' + status);
        }
      });
    }
</script>
                                    
                                 
                                </div>
                                @endif
                                </div>
                                
                              
                               <div class="mt-4 text-right">
                                <button class="btn btn-primary" type="submit">
                                    @if($id==3)
                                اضافة عميل 
                            @elseif($id=='1')
                            اضافة مكتبه 
                             @elseif($id=='2')
                            اضافة دور نشر 
                              @else 
                               اضافة  كاتب 
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
      