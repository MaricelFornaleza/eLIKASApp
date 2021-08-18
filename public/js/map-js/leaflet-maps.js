/*
|--------------------------------------------------------------------------
| Leaflet
|--------------------------------------------------------------------------
|
| Here is where you can choose which tile provider to use. e.g:
| Openstreetmaps
| Mapbox
|
*/


// var mymap = L.map('mapid').setView([13.6218, 123.1948], 15);
var mymap = L.map('mapid', {
  center: [13.6218, 123.1948],
  zoom: 15, 
  doubleClickZoom: false,
})

//----------------------Openstreetmaps
L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,  
    subdomains: ['a','b','c']
}).addTo(mymap);

 // show the scale bar on the lower left corner
L.control.scale().addTo(mymap);

//-----------------------Mapbox
// L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
//     maxZoom: 18,
//     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
//         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
//     id: 'mapbox/streets-v11',
//     tileSize: 512,
//     zoomOffset: -1
// }).addTo(mymap);

var routeControl = L.Routing.control({
  waypoints: [
    L.latLng(markers_truck[0].lat,markers_truck[0].lng),
    L.latLng(markers_evac[1].lat,markers_evac[1].lng)
  ],
  lineOptions: {
    styles: [{color: 'orange', opacity: 1, weight: 5}]
  },
  createMarker: function() { return null; }
}).addTo(mymap);
routeControl.hide();

// L.Routing.control({
//   waypoints: [
//     L.latLng(markers_truck[0].lat,markers_truck[0].lng),
//     L.latLng(markers_evac[1].lat,markers_evac[1].lng)
//   ],
//   router: L.Routing.mapbox('pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw')
// }).addTo(mymap);

routeControl.on('routesfound', function (e) {
  // var routes = e.route;
  // var summary = routes.summary;
  // // alert distance and time in km and minutes
  // console.log('Total distance is ' + summary.totalDistance / 1000 + ' km and total time is ' + Math.round(summary.totalTime % 3600 / 60) + ' minutes');
  var routes = e.routes;
  var summary = routes[0].summary;
  // alert distance and time in km and minutes
  console.log('Total distance is ' + Math.round(summary.totalDistance / 1000) + ' km and total time is ' + secondsToHm(summary.totalTime));
  //console.log(secondsToHm(summary.totalTime));
});

function secondsToHm(d) {
  d = Number(d);
  const h = Math.floor(d / 3600);
  const m = Math.floor(d % 3600 / 60);
  const s = Math.floor(d % 60);
  return ((h > 0 ? h + " h " + (m < 10 ? "0" : "") : "") + m + " min " + (s > 0 ? s + " s" : "")); // eslint-disable-line
}








