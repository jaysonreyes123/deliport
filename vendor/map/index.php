<?php if($_settings->chk_flashdata('success')): ?>

<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.product-img{
		width: calc(100%);
		height: auto;
		max-width: 5em;
		object-fit:scale-down;
		object-position:center center;
	}
    #map { position: relative; top: 10px; bottom: 0; width: 100%;height: 600px; }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Map</h3>

	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="row">
                           
                           <label for="coordinates" class="control-label">Coordinates</label>
                           <input type="text" id="coordinates" name="coordinates" value="<?=$_settings->userdata('coordinates') ?? ""?>" class="form-control form-control-sm form-control-border" required>
                           <button class="btn btn-primary mt-1" id="save_coordinates">Save</button>
                           <div id="map"></div>
                       
        </div>
	</div>
    <input type="hidden" id="id" value="<?=$_settings->userdata('id')?>">
    <input type="hidden" id="current_coordinates" value="<?=$_settings->userdata('coordinates')?>">
</div>
<link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
<script>
     // TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiamF5c29ucmV5ZXMyNiIsImEiOiJjbGd1aDViYXUwZzM2M3BsamlpdWtjbzBsIn0.DmYf96Yhwg7vip5Qpzghnw';
    const coordinates = $("#current_coordinates").val();
    const coordinates_ = coordinates.split(",");
    
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

    if(coordinates_.length >= 2){
        marker.setLngLat([coordinates_[1],coordinates_[0]]).addTo(map);
        map.flyTo({
            center:[coordinates_[1],coordinates_[0]]
        })
    }

    map.on('click',(e)=>{
        marker.setLngLat(e.lngLat).addTo(map);
        $("#coordinates").val(e.lngLat.lat+","+e.lngLat.lng);
        map.flyTo({
            center:[e.lngLat.lng,e.lngLat.lat]
        })
    })

    marker.on('dragend', onDragEnd);

    function onDragEnd() {
        const lngLat = marker.getLngLat();
        $("#coordinates").val(lngLat.lat+","+lngLat.lng);
    }


    $("#save_coordinates").click(function(){


        $.ajax({
            url:_base_url_+"classes/Master.php?f=save_coordinates",
            method:"post",
            type:"post",
            data:{id:$("#id").val(),coordinates:$("#coordinates").val()},
            success:function(data){
                location.reload();
            }
        })

    })

</script>