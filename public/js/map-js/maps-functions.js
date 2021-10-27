function Use_OpenStreetMap() {
  return L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      maxZoom: 19,  
      subdomains: ['a','b','c']
  });
}

function Use_Mapbox() {
  return L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1
  });
}

function routeControl(mapname, source_lat, source_lng, dest_lat, dest_lng) {
  var control = L.Routing.control({
    waypoints: [
      L.latLng(source_lat,source_lng),
      L.latLng(dest_lat, dest_lng)
    ],
    lineOptions: {
      styles: [{color: 'orange', opacity: 1, weight: 5}]
    },
    createMarker: function() { return null; }
  }).addTo(mapname);

  control.hide();

  //return control;
}

function routeControl_Mapbox(mapname, source_lat, source_lng, dest_lat, dest_lng) {
  var control = L.Routing.control({
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

  control.hide();

  //return control;
}

function getDuration(control) {
  control.on('routesfound', function (e) {
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

function addMarker(mymap, clickMarker) {
  mymap.on('click', function (e){
    //clickMarker = new L.marker(e.latlng).addTo(mymap);
    var icon = L.icon({
      iconUrl: '/././assets/img/pins/orange-pin.png',
      iconSize: [61, 52],
      iconAnchor: [15, 48],
      popupAnchor: [170, -20]
    });

    clickMarker.setLatLng(e.latlng).setIcon(icon).addTo(mymap);

    document.getElementById("latitude").value = e.latlng.lat;
    document.getElementById("longitude").value = e.latlng.lng;
    console.log(e.latlng.lat, e.latlng.lng);
    //return e.latlng;
  });
}

function evacIcon() {
  return icon = L.icon({
    iconUrl: '/././assets/img/pins/orange-pin.png',
    iconSize: [61, 52],
    iconAnchor: [9, 48],
    popupAnchor: [196, -24] //[170, -20]
  });
}

function evacOptions() {
  return options = {
    'maxWidth': '400',
    'minWidth': '250',
    'autoClose': false,
    'closeOnClick': false,
    'className': 'custom-popup',
  };
}

function truckIcon() {
  return icon = L.icon({
    iconUrl: 'assets/img/pins/truck_circle_pin.png',
    iconSize: [42, 42],
    iconAnchor: [9, 21],
    popupAnchor: [10, -22]
  });
}

function truckOptions() {
  return options = {
    'maxWidth': '400',
    'minWidth': '100',
    'autoClose': false,
    'closeOnClick': false,
    'className': 'truck-popup'
  };
}

function get_lat() {
  lat = $('#latitude').val();
  lng = $('#longitude').val();
  if(lat && lng) {
    // console.log(lat,lng);
    clickMarker.setLatLng([lat,lng]).setIcon(evacIcon()).addTo(mymap);
  }
}

function get_lng() {
  lat = $('#latitude').val();
  lng = $('#longitude').val();
  if(lat && lng) {
    // console.log(lat,lng);
    clickMarker.setLatLng([lat,lng]).setIcon(evacIcon()).addTo(mymap);
  }
}

function _affectedAreas() {
  return new Promise(function (resolve, reject) {
      $.ajax({
          method: "GET",
          url: "/map/affected_areas",
      }).done(function(data) {
          resolve(data);
      }).fail(function (jqXHR, textStatus) {
          reject(textStatus);
      });
  });
}

function _loadGeoJson() {
  return new Promise(function (resolve, reject) {
      $.getJSON("js/map-js/Barangays.json", function(json) {
          resolve(json);
      }).fail(function (jqXHR, textStatus) {
          reject(textStatus);
      });
  });
}

function drawPolygons(data, json) {
  // console.log(data);
  // console.log(json);
  var city = data.city;
  var province = data.province;
  var affected_areas = data.all_barangays;
  var polyStyle = {
      "color": "red", //#ff7800
      "weight": 2.5,
      "opacity": 0.65
  };
  var barangayLayer = new L.layerGroup();
  $.each(affected_areas, function(key, value) {
    var geo = geoIndex.buildIndex(["NAME_1","NAME_2","NAME_3"], json);
    var geoQuery = new geoIndex.Queries();
    var resByProp = (geoQuery
        .query("NAME_1", "=" , province)
        .and("NAME_2", "=", city)
        .and("NAME_3","=", value.barangay)
        .get());
    L.geoJSON(resByProp, {
      style: polyStyle,
      onEachFeature: onEachFeature,
    }).addTo(barangayLayer);
  });
  // barangayLayer.addTo(mymap);
  // var overlays = {
  //     "Affected Barangays": barangayLayer
  // };

  layerControl.addOverlay(barangayLayer, "Affected Barangays");
  //L.control.layers(null, overlays).addTo(mymap);
}

function onEachFeature(feature, layer) {
  options = {
    'maxWidth': '400',
    'minWidth': '250',
  };
  layer.bindPopup(`<h5 class="font-weight-bold text-center">Barangay ` + feature.properties.NAME_3 + `</h5>`, options);
}

function split(str) {
  return str.
    split(' ').
    map(w => w[0].toUpperCase() + w.substr(1).toLowerCase()).
    join(' ');
}

