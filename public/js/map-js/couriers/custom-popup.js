var truckIcon = L.icon({
    iconUrl: 'assets/img/pins/mdi_truck-fast.png',
    iconSize: [32, 27],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var truckOptions = {
    'maxWidth': '400',
    'minWidth': '100',
    'autoClose': false,
    'closeOnClick': false,  
    'className' : 'custom-popup'
}

for (var i = 0; i < markers_truck.length; ++i) {
    L.marker([markers_truck[i].lat, markers_truck[i].lng], {icon: truckIcon})
        .bindPopup('<div class="font-weight-bold text-center">' + markers_truck[i].time + '</div>' +
        '<div class="my-2">' + markers_truck[i].street + '</div>', truckOptions)
        .addTo(mymap);
}