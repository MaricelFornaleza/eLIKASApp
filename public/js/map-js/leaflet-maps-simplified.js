var OpenStreetMap = Use_OpenStreetMap(),
  Mapbox = Use_Mapbox();

var mymap = L.map('mapid', {
  center: [13.6331, 123.2041],
  zoom: 14, 
  doubleClickZoom: false,
  layers: [OpenStreetMap]
});
L.control.scale().addTo(mymap);

L.Control.geocoder({
  query: 'Philippines',
  placeholder: 'Search here...',
  defaultMarkGeocode: false
}).on('markgeocode', function(e) {
  var bbox = e.geocode.bbox;
  var poly = L.polygon([
    bbox.getSouthEast(),
    bbox.getNorthEast(),
    bbox.getNorthWest(),
    bbox.getSouthWest()
  ]);
  mymap.fitBounds(poly.getBounds());
}).addTo(mymap);
// geoControl.setQuery('Earth');

var baseMaps = {
  "OpenStreetMap": OpenStreetMap,
  "Mapbox": Mapbox
};

var layerControl = new L.control.layers(baseMaps).addTo(mymap);


// routeControl(mymap, markers_truck[0].lat,markers_truck[0].lng, markers_evac[1].lat,markers_evac[1].lng);







