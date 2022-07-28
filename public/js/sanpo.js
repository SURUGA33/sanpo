function initAutocomplete() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 34.95483280899109, lng: 137.17304429898508 },
    zoom: 13,
    mapTypeId: "roadmap",
    styles: [{
      featureType: 'road',
       stylers: [{
           hue: '#ff0' 
       }, {
           saturation: -50 
       }, {
           lightness: 0 
       }, {
           gamma: 0.5 
       }]
   }]


   
  });
  // Create the search box and link it to the UI element.
  const input = document.getElementById("pac-input");
  const searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });
  let markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    // Clear out the old markers.
    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];
    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();
    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }
      const icon = {
        url: 'buta.png',
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(50, 50),
      };
      // Create a marker for each place.
      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
        })
      );

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });


  google.maps.event.addListener(map, 'click', event => clickListener(event, map));    /*clickListenerへ*/

  infoWindow = new google.maps.InfoWindow({ // 吹き出しの追加
    content: '<div class="sample">TAM 大阪</div>' // 吹き出しに表示する内容
});


}

// This example adds a marker to indicate the position of Bondi Beach in Sydney,
// Australia.
function initMap() {
const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 4,
  center: { lat: -33, lng: 151 },
});
const image =
  "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
const beachMarker = new google.maps.Marker({
  position: { lat: -33.89, lng: 151.274 },
  map,
  icon: image,
});
}

window.initMap = initMap;


function createMarker(id, name, lat, lng) {
  let marker = new google.maps.Marker({
    position: { lat: lat, lng: lng },
    map: map,
    name: name,
    icon: "neko",
    animation: google.maps.Animation.DROP,
  });
  
  marker.addListener("click", () => {
    infoWindow.open({
        anchor: marker,
        map,
        shouldFocus: false,
    })
  });
 
  return marker;
}




/*ピンを立てる*/

function clickListener(event, map) {
  const lat = event.latLng.lat();
  const lng = event.latLng.lng();
  const marker = new google.maps.Marker({
    position: {lat, lng},
    map
  });

  infoWindow.open(map, marker);

  console.log(map)
  console.log(marker)
 /* window.location.href = 'input.html';    /*ピンを立てたらinput.htmlへとぶ*/ 
}