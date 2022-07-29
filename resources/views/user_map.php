<?php
session_start();
include_once 'header.php';
include 'locations_model.php';
//get_unconfirmed_locations();exit;
?>
    <style>

        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            margin-left: 20%;
            width:50%
        }
        #map { position:absolute;left: 350px; top:600px; bottom:0px;height:550px ;width:660px; }
        .geocoder {
            position:absolute;left: 350px; top:290px;
        }
    </style>

    <h3>how to add location in google map ?</h3>

    <div class="container">
        <form accept-charset="UTF-8" action="./locations_model.php" method="post" enctype="multipart/form-data" id="signupForm" >
            <?php
            echo !empty($_SESSION['message']) ? $_SESSION['message'] : '' ; ?>
            <h2 class="page-header">map_search</h2>

            <input id="pac-input" class="form-control" type="text" placeholder="Enter a location">
            <br>
            <label for="store_name">store name</label>
            <input type="text" id="store_name" name="store_name" >
            <label for="latitude">lat</label>
            <input type="text" id="latitude" name="latitude" placeholder="Your lat..">

            <label for="longitude">lng</label>
            <input type="text" id="longitude" name="longitude" placeholder="Your lng..">
                <label for="longitude">ADDRESS</label>
            <input type="text" id="address" name="address" placeholder="Your lng..">
            <br>
            <input type="submit">
        </form>
        <div id="map" style="height: 500px"></div>

    </div>




    <script>
        var map, infoWindow;
        var geocoder;
        function initMap() {

            // Display a map on the page
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -33.865143, lng: 151.209900},
                mapTypeId: 'roadmap',
                zoom: 10
            });

            map.setTilt(45);

            // Try HTML5 geolocation to get location
              infoWindow = new google.maps.InfoWindow;
              geocoder = new google.maps.Geocoder;
            var  input = document.getElementById('pac-input');

            var autocomplete = new google.maps.places.Autocomplete(
                input, {placeIdOnly: true});
                autocomplete.bindTo('bounds', map);


//
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    var marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        draggable: true,
                        title: 'Your position'
                    });
                    /*infoWindow.setPosition(pos);
                    infoWindow.setContent('Your position');
                    marker.addListener('click', function() {
                      infoWindow.open(map, marker);
                    });
                    infoWindow.open(map, marker);*/
                    map.setCenter(pos);

                    updateMarkerPosition(marker.getPosition());
                    geocodePosition(pos);

                    // Add dragging event listeners.
                    google.maps.event.addListener(marker, 'dragstart', function() {
                        updateMarkerAddress('Dragging...');
                    });

                    google.maps.event.addListener(marker, 'drag', function() {
                        updateMarkerStatus('Dragging...');
                        updateMarkerPosition(marker.getPosition());
                    });

                    google.maps.event.addListener(marker, 'dragend', function() {
                        updateMarkerStatus('Drag ended');
                        geocodePosition(marker.getPosition());
                        map.panTo(marker.getPosition());
                    });

                    google.maps.event.addListener(map, 'click', function(e) {
                        updateMarkerPosition(e.latLng);
                        geocodePosition(marker.getPosition());
                        marker.setPosition(e.latLng);
                        map.panTo(marker.getPosition());
                    });

                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }

            //
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();

                if (!place.place_id) {
                    return;
                }
                geocoder.geocode({'placeId': place.place_id}, function (results, status) {

                    if (status !== 'OK') {
                        window.alert('Geocoder failed due to: ' + status);
                        return;
                    }
                    map.setZoom(10);
                    map.setCenter(results[0].geometry.location);
                    // Set the position of the marker using the place ID and location.

                });
            });
        }

        //
        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    updateMarkerAddress(responses[0].formatted_address);
                } else {
                    updateMarkerAddress('Cannot determine address at this location.');
                }
            });
        }
        function updateMarkerStatus(str) {
          //  document.getElementById('markerStatus').innerHTML = str;
        }
        function updateMarkerPosition(latLng) {
            $("#latitude").val(latLng.lat());
            $("#longitude").val(latLng.lng());

        }
        function updateMarkerAddress(str) {
            $("#address").val(str);
        }
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    </script> // IMPORTANT NOTE : CHANGE THE API KEY FIRST
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdMfA0kydGyZo6BY42hHW5KFkLNl95Uf0&callback=initAutocomplete&libraries=places&v=weekly"
            async defer></script>
<?php
include_once 'footer.php';

?>