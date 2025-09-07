<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Place Search</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <input type="text" id="placeInput" placeholder="Enter a place name">
    <button onclick="searchPlace()">Search</button>
    <div id="map"></div>

    <script>
        function searchPlace() {
            var placeName = document.getElementById('placeInput').value;
            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({ 'address': placeName }, function(results, status) {
                if (status === 'OK') {
                    var mapOptions = {
                        center: results[0].geometry.location,
                        zoom: 15
                    };
                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
    
    <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</body>
</html>
