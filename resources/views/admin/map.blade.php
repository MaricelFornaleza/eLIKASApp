@extends('layouts.webBase')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
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
        height: 680px;
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
                    <div class="card-header">Location of Evacuation Centers</div>
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

<script src="{{ asset('js/map-js/evacuation-centers/markers-evacuationCenters.js') }}"></script>
<script src="{{ asset('js/map-js/couriers/markers-Couriers.js') }}"></script>

<script src="{{ asset('js/map-js/leaflet-maps.js') }}"></script>

<!-- <script src="{{ asset('js/map-js/customOptions.js') }}"></script> -->
<script src="{{ asset('js/map-js/couriers/customShow.js') }}"></script>
<script src="{{ asset('js/map-js/evacuation-centers/customShow.js') }}"></script>

@endsection
