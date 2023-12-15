<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Create a draggable Marker</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
<style>
body { margin: 0; padding: 0; }
#map { position: relative; top: 0; bottom: 0; width: 100%;height: 400px; }
</style>
</head>
<body>
<style>
    .coordinates {
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        position: absolute;
        bottom: 40px;
        left: 10px;
        padding: 5px 10px;
        margin: 0;
        font-size: 11px;
        line-height: 18px;
        border-radius: 3px;
        display: none;
    }
</style>

<div id="map"></div>
<pre id="coordinates" class="coordinates"></pre>


<button onclick="get_location()">click</button>

<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiamF5c29ucmV5ZXMyNiIsImEiOiJjbGd1aDViYXUwZzM2M3BsamlpdWtjbzBsIn0.DmYf96Yhwg7vip5Qpzghnw';
    const coordinates = document.getElementById('coordinates');
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [120.90951205079591,15.043758289319861],
        zoom: 10
    });

    const marker = new mapboxgl.Marker({
        draggable: true
    })

    function onDragEnd() {
        const lngLat = marker.getLngLat();
        coordinates.style.display = 'block';
        coordinates.innerHTML = `Longitude: ${lngLat.lng}<br />Latitude: ${lngLat.lat}`;
    }

    map.on('click',(e)=>{
        marker.setLngLat(e.lngLat).addTo();
    })

    marker.on('dragend', onDragEnd);



    function get_location(){
        console.log(marker.getLngLat())
    }
</script>

</body>
</html>