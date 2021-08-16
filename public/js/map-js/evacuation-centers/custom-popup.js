// var evacIcon = L.icon({
//     iconUrl: 'assets/img/pins/orange-pin.png',
//     iconSize: [61, 52],
//     iconAnchor: [9, 48],
//     popupAnchor: [170, -20]
// });

var evacPopup = 
  '<div class="my-2">' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>Food</div>' +
        '<div class="ml-auto font-weight-bold mr-2">191.235</div>' +
        '<div class="text-muted small">(56%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>Water</div>' +
        '<div class="ml-auto font-weight-bold mr-2">51.223</div>' +
        '<div class="text-muted small">(15%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>Clothes</div>' +
        '<div class="ml-auto font-weight-bold mr-2">37.564</div>' +
        '<div class="text-muted small">(11%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>Hygiene Kit</div>' +
        '<div class="ml-auto font-weight-bold mr-2">27.319</div>' +
        '<div class="text-muted small">(8%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>Medicine</div>' +
        '<div class="ml-auto font-weight-bold mr-2">27.319</div>' +
        '<div class="text-muted small">(8%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
    '<div class="progress-group">' +
      '<div class="progress-group-header align-items-end">' +
        '<div>ESA</div>' +
        '<div class="ml-auto font-weight-bold mr-2">27.319</div>' +
        '<div class="text-muted small">(8%)</div>' +
      '</div>' +
      '<div class="progress-group-bars">' +
        '<div class="progress progress-xs">' +
          '<div class="progress-bar bg-warning" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
        '</div>' +
      '</div>' +
    '</div>' +
  '</div>';

var evacOptions = {
    'maxWidth': '400',
    'minWidth': '250',
    'autoClose': false,
    'closeOnClick': false,  
    'className' : 'custom-popup'
}

for (var i = 0; i < markers_evac.length; ++i) {
  L.marker([markers_evac[i].lat, markers_evac[i].lng], {icon: evacIcon})
      .bindPopup('<div class="font-weight-bold">' + markers_evac[i].name + '</div>' + evacPopup, evacOptions)
      .addTo(mymap);
}