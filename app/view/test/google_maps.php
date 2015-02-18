<?php
/**
 * User: Samuel
 * Date: 2/17/2015
 * Time: 11:46 PM
 */
?>
<style type="text/css">
    html, body, #map-canvas {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?sensor=true?key=AIzaSyCg9ct3rgITPTL2erAKVHbrwwGsVpbCNKo">
    //The source has a get request (key) that is our specific key. No one else should be able to use this!
</script>
<script type="text/javascript">
    //Just some latitude and longitude coordinates to be used as an example

    var myLatlng = new google.maps.LatLng(-25.363882, 131.044922);


    //Get the coordinates of the user's position
    if (!navigator.geolocation) {
        alert('Cannot get current position!');
    } else {
        var success_callback = function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            alert(lat + ' ' + lng);
            myLatlng = new google.maps.LatLng(lat, lng);

        };
        var error_callback = function (error) {
            alert('Sorry, the following error occurred \n ' + error);
        };
        navigator.geolocation.getCurrentPosition(success_callback, error_callback)
    }


    //https://developers.google.com/maps/documentation/javascript/tutorial
    function initialize() {


        var mapOptions = {
            center: myLatlng,
            zoom: 12,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
            }
            //mapTypeId: google.maps.MapTypeId.TERRAIN
            //mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        //The element in which the map resides
        var canvas = document.getElementById('map-canvas');     // ~or~  canvas = $('#map-canvas');

        //An optional object array containing different styles for different components of google maps
        /*
         var styleArray = [
         {
         featureType: "all",
         stylers: [
         { saturation: -80 }
         ]
         },{
         featureType: "road.arterial",
         elementType: "geometry",
         stylers: [
         { hue: "#00ffee" },
         { saturation: 50 }
         ]
         },{
         featureType: "poi.business",
         elementType: "labels",
         stylers: [
         { visibility: "off" }
         ]
         }
         ];
         var styledMap = new google.maps.StyledMapType(styleArray, {name: 'Styled Map'});    */

        // Create a map object inside of the canvas, and include the MapTypeId to add to the map type control.
        var map = new google.maps.Map(canvas, mapOptions);

        //Associate the styled map with the MapTypeId and set it to display.
        /* map.mapTypes.set('map_style', styledMap); map.setMapTypeId('map_style'); */


        //it'd be a good idea to make an array of markers
        var marker_array = [];

        var marker_obj_example = new google.maps.Marker({
            //The coordinates of the marker
            position: myLatlng,
            //The map object on which the marker resides
            map: map,
            //What comes up in a tooltip
            title: 'Hello World!'
        });

        //Do something when the marker is clicked. This kind of function must be run for every marker that is added!
        google.maps.event.addListener(marker_obj_example, 'click', function () {
            map.setZoom(map.getZoom() + 3);
            map.setCenter(marker_obj_example.getPosition());
        });

        //To remove the specific marker from the map
        //marker_obj_example.setMap(null);

        //find the center of the map (What the user sees)
        var mapCenterNow = map.getCenter();

        //go to the latitude and longitude provided to the function
        map.setCenter(mapCenterNow);


        //setInterval(function(){alert(map.getCenter())}, 10000)
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
<div style="height:500px; width:500px;"> <!-- ommiting the height and width will not show the map -->
    <div id="map-canvas"></div>
</div>