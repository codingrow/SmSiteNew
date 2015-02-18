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
        src="https://maps.googleapis.com/maps/api/js?key=API_KEY">
</script>
<script type="text/javascript">
    function initialize() {
        var mapOptions = {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="map-canvas"></div>