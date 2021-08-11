function Use_OpenStreetMap(mapname) {
  L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      maxZoom: 19,  
      subdomains: ['a','b','c']
  }).addTo(mapname);

  L.control.scale().addTo(mapname);
}

function Use_Mapbox(mapname) {
  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1
  }).addTo(mapname);
}

function routeControl(mapname, source_lat, source_lng, dest_lat, dest_lng) {
  routeControl = L.Routing.control({
    waypoints: [
      L.latLng(source_lat,source_lng),
      L.latLng(dest_lat, dest_lng)
    ],
    lineOptions: {
      styles: [{color: 'orange', opacity: 1, weight: 5}]
    },
    createMarker: function() { return null; }
  }).addTo(mapname);

  routeControl.hide();
}

function routeControl_Mapbox(mapname, source_lat, source_lng, dest_lat, dest_lng) {
  routeControl = L.Routing.control({
    waypoints: [
      L.latLng(source_lat,source_lng),
      L.latLng(dest_lat, dest_lng)
    ],
    lineOptions: {
      styles: [{color: 'orange', opacity: 1, weight: 5}]
    },
    router: L.Routing.mapbox('pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'),
    createMarker: function() { return null; }
  }).addTo(mapname);

  routeControl.hide();
}

function getDuration() {
  routeControl.on('routesfound', function (e) {
    var routes = e.routes;
    var summary = routes[0].summary;
    // alert distance and time in km and minutes
    console.log('Total distance is ' + Math.round(summary.totalDistance / 1000) + ' km and total time is ' + secondsToHm(summary.totalTime));
    //console.log(secondsToHm(summary.totalTime));
    return Math.round(summary.totalDistance / 1000) + ' km ' + secondsToHm(summary.totalTime);
  });
}

function secondsToHm(d) {
  d = Number(d);
  const h = Math.floor(d / 3600);
  const m = Math.floor(d % 3600 / 60);
  const s = Math.floor(d % 60);
  return ((h > 0 ? h + " h " + (m < 10 ? "0" : "") : "") + m + " min " + (s > 0 ? s + " s" : "")); // eslint-disable-line
}



