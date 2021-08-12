@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<style>
      /*
      * These CSS rules affect the tooltips within maps with the custom-popup
      * class. See the full CSS for all customizable options:
      * https://github.com/mapbox/mapbox.js/blob/001754177f3985c0e6b4a26e3c869b0c66162c99/theme/style.css#L321-L366
      */
  .custom-popup .leaflet-popup-content-wrapper {
    font-size:12px;
    line-height:24px;
    border-radius: 8px;
  }
  .custom-popup .leaflet-popup-content-wrapper a {
    color:rgba(255,255,255,0.5);
  }
  .custom-popup .leaflet-popup-tip-container {
    /* width:50px;
    height:15px; */
    width:50px;
    margin:0 auto;
  }
  .custom-popup .leaflet-popup-tip {
    width:0;
    height:0;
    margin:0;
    box-shadow:none;
    display:none;
  }
  .custom-popup .leaflet-popup-close-button {
    /* display:none;
    pointer-events:none; */
    margin: 10px 12px 0px 0px;
  }
  .leaflet-control-container .leaflet-routing-container-hide {
    display: none;
  }

  #mapid {
    height: 75vh;
  }
}
</style>
@endsection

@section('content')

    <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header "> <h4 class="my-auto">{{ __('Location of Evacuation Centers') }}</h4></div>
                    <div class="card-body">

                        <div class="w-100" id="mapid"></div>

                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
            </div>
          </div>

@endsection

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="{{ asset('js/map-js/evacuation-centers/markers-evacuationCenters.js') }}"></script>
<script src="{{ asset('js/map-js/couriers/markers-Couriers.js') }}"></script> --}}

{{-- <!-- <script src="{{ asset('js/map-js/leaflet-maps.js') }}"></script> --> --}}

{{-- <!-- <script src="{{ asset('js/map-js/customOptions.js') }}"></script> -->
<!-- <script src="{{ asset('js/map-js/couriers/custom-popup.js') }}"></script>
<script src="{{ asset('js/map-js/evacuation-centers/custom-popup.js') }}"></script> --> --}}

<script src="{{ asset('js/map-js/maps-functions.js') }}"></script>
<script src="{{ asset('js/map-js/leaflet-maps-simplified.js') }}"></script>

<script type="text/javascript">
var evacOptions = {
    'maxWidth': '400',
    'minWidth': '250',
    'autoClose': false,
    'closeOnClick': false,  
    'className' : 'custom-popup'
}

$(document).ready(function(){
  $.ajax({ 
    method: "GET", 
    url: "/map/get_evac",
  }).done(function( data ) { 
    //console.log(data);
    var result = data;
    var length = 0;
    $.each( result, function( key, value ) {
      
      //console.log("id: ", value[1].id, "camp_manager_id: ", value[1].camp_manager_id, "name: ", value[1].name, "address: ", value[1].address,
      //"latitude: ", value[1].latitude, "longitude: ", value[1].longitude, "capacity: ", value[1].capacity, "characteristics: ", value[1].characteristics);
     // console.log("name: ", value[length].name, "camp_manager_id: ", value[length].camp_manager_id);
      
      //---------change total of 100 to the true total of each stock levels ---to be updated/changed in the future 
      //either store in a variable to add all or query from DB the total of all then pass
      for (var i = 0; i < value.length; ++i) {
        //console.log(i);
        L.marker([value[i].latitude, value[i].longitude], {icon: evacIcon()})
          .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>' +
                  '<div class="my-2">' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>Food</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].food_packs +'</div>' +
                        '<div class="text-muted small">(' + (value[i].food_packs / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].food_packs / 100 * 100) + '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>Water</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].water +'</div>' +
                        '<div class="text-muted small">(' + (value[i].water / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].water / 100 * 100) + '%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>Clothes</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].clothes +'</div>' +
                        '<div class="text-muted small">(' + (value[i].clothes / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].clothes / 100 * 100) + '%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>Hygiene Kit</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].hygiene_kit +'</div>' +
                        '<div class="text-muted small">(' + (value[i].hygiene_kit / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].hygiene_kit / 100 * 100) + '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>Medicine</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].medicine +'</div>' +
                        '<div class="text-muted small">(' + (value[i].medicine / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].medicine / 100 * 100) + '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                    '<div class="progress-group">' +
                      '<div class="progress-group-header align-items-end">' +
                        '<div>ESA</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' +  value[i].emergency_shelter_assistance +'</div>' +
                        '<div class="text-muted small">(' + (value[i].emergency_shelter_assistance / 100 * 100) + '%)</div>' +
                      '</div>' +
                      '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                          '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + (value[i].emergency_shelter_assistance / 100 * 100) + '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                  '</div>'
          ,evacOptions)
          .addTo(mymap);
      }

        // for (var i = 0; i < markers_evac.length; ++i) {
        //   L.marker([markers_evac[i].lat, markers_evac[i].lng], {icon: evacIcon})
        //       .bindPopup('<div class="font-weight-bold">' + markers_evac[i].name + '</div>' + evacPopup, evacOptions)
        //       .addTo(mymap);
        // }
    }); 
    //string += '</table>'; 
    //$("#records").html(string); 
  });  
});
</script>
@endsection
