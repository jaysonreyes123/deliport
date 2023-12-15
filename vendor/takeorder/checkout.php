<style>
    * {
	box-sizing: border-box;
}

body {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
	padding: 0;
	margin: 0;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	color: #555;
	background-color: lightseagreen;
}

.datetimepicker {
	display: inline-flex;
	align-items: center;
	background-color: #fff;
	border: 4px solid darkturquoise;
	border-radius: 8px;
	
	&:focus-within {
		border-color: teal;
	}
	
	input {
		font: inherit;
		color: inherit;
		appearance: none;
		outline: none;
		border: 0;
		background-color: transparent;
		
		&[type=date] {
			width: 10rem;
			padding: .25rem 0 .25rem .5rem;
			border-right-width: 0;
		}
		
		&[type=time] {
			width: 5.5rem;
			padding: .25rem .5rem .25rem 0;
			border-left-width: 0;
		}
	}
	
	span {
		height: 1rem;
		margin-right: .25rem;
		margin-left: .25rem;
		border-right: 1px solid #ddd;
	}
}

.info {
	padding-top: .5rem;
	font-size: .8rem;
	color: rgba(255, 255, 255, .5);
}
#map { position: relative; top: 10px; bottom: 0; width: 100%;height: 400px; }
    </style>
      <?php
        $store_list = $conn->query("SELECT * from vendor_list where is_supplier = 1 and `status` = 1 and delete_flag = 0 ");
        $store_list_ = array();
        while($rows = $store_list->fetch_assoc()){
            $store_list_[] = array("id" => $rows["id"], "name" => $rows["shop_name"] ,"address" => $rows["address"] );
        }
    ?>
     <?php 
                    $gtotal = 0;
                    $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list_vendor where id in (SELECT product_id FROM `cart_list_vendor` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                    while($vrow=$vendors->fetch_assoc()):    
                    $vtotal = $conn->query("SELECT sum(c.quantity * c.price) FROM `cart_list_vendor` c inner join product_list_vendor p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}'")->fetch_array()[0];   
                    $vtotal = $vtotal > 0 ? $vtotal : 0;
                    $gtotal += $vtotal;

                    ?>

  
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <div class="h5 card-title">Checkout</div>
        </div>
        <div class="card-body">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-id="<?=$_GET["method"] == "order" ? 0 : 1 ?>" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><?=ucfirst($_GET["method"])?></a>
                        </li>
                    </ul>
            <div class="row">
                
                <div class="col-md-8">
                    <form action="" id="checkout-form">
                    
                    <div class="tab-content" id="pills-tabContent">
                  
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recieved Order Via: </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <select id="option" class="form-control" name="option" required>  
                                            <option value = "" disabled selected> Select option </option> 
                                            <option value = "pickup" > Pickup </option>  
                                            <option value = "delivery" > Delivery </option>  
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Details</h3>
                                </div>
                                <div class="card-body" id="detail_body" style="display: none;">
                                    <div class="form-group" id="pickup_time">
                                        <label for="">Time of pickup:</label>
                                        <input type="text" required readonly class="datetimepickers form-control" name="deliverydate" id="deliverydate">
                                    </div>

                                    <div class="form-group">
                                        <label for="" id="deliveryaddress">PICKUP LOCATION:</label>
                                        <input type="text" id="delivery_address" name="delivery_address" class="form-control"  name="" id="">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Store List:</label>
                                        <select class="form-control" name="storelist" id="storelist"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Delivery fee:</label>
                                        <input type="text" name="delivery_fee" class="form-control" readonly id="delivery_fee">
                                    </div>

                                    <div class="form-group" id="map_order_now" style="display: none;">
                                    <div id="map"></div>
                                    </div>
                                   
                                    
                                </div>
                            </div>

                   
                      
                    </div>
                        <!-- <div class="form-group">
                            <label for="delivery_address" class="control-label">Delivery Address</label>
                            <textarea name="delivery_address" id="delivery_address" rows="4" class="form-control rounded-0" required><?= $_settings->userdata('address') ?></textarea>
                        </div>

                        <div id="map"></div>
                        <br>
                        <select id="option" name="option" required>  
        <option value = "" selected> Select option </option>  
        <option value = "delivery" > delivery </option>  
        <option value = "pickup" > pick up </option>  
    
      </select>  

      <label for="datetime">Date and Time:</label>
        <input type="datetime-local" id="deliverydate" name="deliverydate" >

        <select id="storelist"></select> -->


      
                        <div class="form-group text-right">
                            <button class="btn btn-flat btn-default btn-sm bg-navy">Place Order</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-4">
                    <div class="row" id="summary">
                    <div class="col-12 border">
                        <h2 class="text-center"><b>Summary</b></h2>
                    </div>
                   
                    <div class="col-12 border item">
                        <b class="text-muted"><small><?= $vrow['code']." - ".$vrow['shop_name'] ?></small></b>
                        <div class="text-right"><b><?= format_num($vtotal) ?></b></div>
                    </div>
<input type="hidden" id="pickup_address"  id="">
<input type="hidden" id="del_address" value="<?=$_settings->userdata('house_no')." ".$_settings->userdata('street')." ".$_settings->userdata('barangay')." ".
$_settings->userdata('municipality')." ".$_settings->userdata('province')?>">
                    <?php endwhile; ?>
                    <div class="col-12 border">
                        <b class="text-muted">Grand Total</b>
                        <div class="text-right h3" id="total"><b><?= format_num($gtotal) ?></b></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
//     var dateEl = document.getElementById('date');
//     var timeEl = document.getElementById('time');

// document.getElementById('date-output').innerHTML = dateEl.type === 'date';
// document.getElementById('time-output').innerHTML = timeEl.type === 'time';
</script>
<link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
alert("loading...");
var store_list__ = <?=json_encode($store_list_)?>;

  var date = new Date();
   var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
   var today_ = new Date(date.getFullYear(), date.getMonth(), date.getDate()+5);
   var hour = date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate()+" "+date.getHours()+":00";

$(".nav a").click(function(){
    $("#option").val("").trigger('change');
    $("#deliverydate").val("");
    if($(this).data("id") == 1){
    }
    else{

    }
})

function getdate(dates){
    return dates;
}

$("#storelist").change(function(){
    if($("#option").val() == "pickup"){
        var option = $(this).find("option:selected");
        $("#delivery_address").val(option.data("address"))
    }
    
})
    $("#option").change(function(){
        var method =  $(".nav .nav-item .nav-link.active").data("id");
        $("#detail_body").show();
        var delivery_fee = 0;
        if($(this).val() == "pickup"){
            $("#deliveryaddress").text("PICKUP LOCATION")
            $("#pickup_time").show();
            $("#map_order_now").hide();
            $("#delivery_address").val("");
            $("#storelist").empty();
            $("#delivery_address").attr("readonly",true)
            store_list__.map((item,index)=>{
                if(index == 0){
                    $("#delivery_address").val(item.address)
                }
                $("#storelist").append("<option value="+item.id+" data-address='"+item.address+"'>"+item.name+"</option>");
            })

            delivery_fee = 0;
        }
        else if($(this).val()=="delivery"){
            getstreet($("#del_address").val());
            $("#deliveryaddress").text("DELIVERY ADDRESS")
            $("#delivery_address").val($("#del_address").val());
            if(method ==0){
                $("#pickup_time").hide();
            }
            $("#map_order_now").show();
            $("#delivery_address").removeAttr("readonly")

            delivery_fee = 50;
            
        }
        else{
            $("#detail_body").hide();
        }
        $("#delivery_fee").val(delivery_fee)
    })

    $("#delivery_address").blur(function(){
        getstreet($(this).val());
    })
    
    $(".datetimepickers").datetimepicker({
        scrollTime:true,
        format:"Y-m-d H:i",
        step:30,
        minTime:0,
        maxTime:"18:30",
        pickDate : false ,
        onSelectDate:function(ct){
            var current_date = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
            var selected_date = ct.getFullYear()+"-"+(ct.getMonth()+1)+"-"+ct.getDate();
            
            if(selected_date == current_date){
                this.setOptions({ minTime: 0 });
                if(date.getHours() >= 18){
                    $("#deliverydate").val("")
                }
            }
            else{
                this.setOptions({ minTime: "08:00",scrollTime:true });
            }
            
        },
        onShow:function(){
            var method =  $(".nav .nav-item .nav-link.active").data("id");
            var current_date = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+(date.getDate()+5);
            if(method ==1){
                this.setOptions({minDate:current_date,minTime:"08:00"})
            }
            else{
                this.setOptions({minDate:today,minTime:0})
            }
        }
    });
    $('#checkout-form').submit(function(e){
        e.preventDefault();
        var method =  $(".nav .nav-item .nav-link.active").data("id");
        var _this = $(this)
        if(_this[0].checkValidity() == false){
            _this[0].reportValidity()
            return false;
        }

        var option__ = $("#option").val();
        if(method == 0){
            if($("#option").val()=="pickup"){
                if($("#deliverydate").val() == ""){
                    alert(option__+" time is required");
                    return false;
                }
            }
        }
        else{
            alert(option__+" time is required");
            return false;
        }

        if($('#summary .item').length <= 0){
            alert_toast("There is no order listed in the cart yet.",'error')
            return false;
        }
        $('.pop_msg').remove();
        var el = $('<div>')
            el.addClass("alert alert-danger pop_msg")
            el.hide()
        start_loader()
        $.ajax({
            url:_base_url_+'classes/Master.php?f=place_order_vendor',
            method:'POST',
            data:_this.serialize()+"&method="+method,
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast("An error occurred.",'error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                   location.replace('./?page=takeorder')
                }else if(!!resp.msg){
                    el.text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                }else{
                    el.text("An error occurred.")
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                }
                end_loader()
            }
        })
    })
</script>

<script>
    // var store_lists;
    // $(function(){
    //     function store_list(){
    //         $.ajax({
    //             url:_base_url_+"classes/Master.php?f=store_list",
    //             success:function(data){
    //                 console.log(data);
    //                 store_lists = JSON.parse(data);
    //             }

                
    //         })
            
    //     }
    //     //store_list();
    // })
    //  // TO MAKE THE MAP APPEAR YOU MUST
	// // ADD YOUR ACCESS TOKEN FROM
	// // https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiamF5c29ucmV5ZXMyNiIsImEiOiJjbGd1aDViYXUwZzM2M3BsamlpdWtjbzBsIn0.DmYf96Yhwg7vip5Qpzghnw';
    
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [120.90951205079591,15.043758289319861],
        zoom: 17
    });

//     const geocoder = new MapboxGeocoder({
//   // Initialize the geocoder
//   accessToken: mapboxgl.accessToken, // Set the access token
//   mapboxgl: mapboxgl, // Set the mapbox-gl instance
//   marker: false, // Do not use the default marker style
//   countries: 'ph',
// });

// Add the geocoder to the map
// map.addControl(geocoder);


    var store_list;
    $.ajax({
        url:_base_url_+"classes/Master.php?f=store_list_vendor",
        success:function(data){
            var result = JSON.parse(data);
            store_list = result;
            console.log(result);
            map.on('load', () => {
                // Load an image from an external URL.
                map.loadImage(
                'https://png.pngtree.com/png-clipart/20190516/original/pngtree-vector-shop-icon-png-image_3762863.jpg',
                (error, image) => {
                if (error) throw error;
                        
                        // Add the image to the map style.
                        map.addImage('cat', image);
                        
                        // Add a data source containing one point feature.
                        map.addSource('point',result);
                        
                        // Add a layer to use the image to represent the data.
                        map.addLayer({
                            'id': 'point',
                            'type': 'symbol',
                            'source': 'point', // reference the data source
                            'layout': {
                                'icon-image': 'cat', // reference the image
                                'icon-size': 0.03
                            }
                        });
                        const popup = new mapboxgl.Popup({
                            closeButton: false,
                            closeOnClick: false
                        });
                        map.on("mouseenter","point",(e)=>{
                            map.getCanvas().style.cursor = 'pointer';
                            const shop_name = e.features[0].properties.description;
                            const coordinates = e.features[0].geometry.coordinates;
                            popup.setLngLat(coordinates).setHTML(shop_name).addTo(map);
                        })
                        map.on('mouseleave', 'point', () => {
                            map.getCanvas().style.cursor = '';
                            popup.remove();
                        });
                    }
                );
            });
        }        
    })

    const marker = new mapboxgl.Marker({
        draggable: true
    })
    //geo locate result
//     geocoder.on('result', (event) => {
//     const coordinates = event.result.geometry.coordinates;
//     marker.setLngLat(coordinates).addTo(map);
//     get_distance(coordinates[0],coordinates[1])
//   });

  //click map
    map.on('click',(e)=>{
        marker.setLngLat(e.lngLat).addTo(map);
        map.flyTo({
            center:[e.lngLat.lng,e.lngLat.lat]
        })
        var coordinates = e.lngLat.lng+","+e.lngLat.lat;
        getaddressname(coordinates)
        get_distance(e.lngLat.lng,e.lngLat.lat)    
    })
    //drag icon
    marker.on('dragend', onDragEnd);
    function onDragEnd() {
        const lngLat = marker.getLngLat();
        var coordinates = lngLat.lng+","+lngLat.lat;
        get_distance(lngLat.lng,lngLat.lat);
        getaddressname(coordinates);
    }

    function getstreet(location){
        $.get("https://api.mapbox.com/geocoding/v5/mapbox.places/"+location+".json?access_token="+mapboxgl.accessToken).done(function(data){
            console.log(data.features[0].center);
            marker.setLngLat(data.features[0].center).addTo(map);
            map.flyTo({
                center:[data.features[0].center[0],data.features[0].center[1]]
            })
            get_distance(data.features[0].center[0],data.features[0].center[1])  
             
        })
    }
    function getaddressname(location){
        $.get("https://api.mapbox.com/geocoding/v5/mapbox.places/"+location+".json?access_token="+mapboxgl.accessToken).done(function(data){
            
            console.log() 
            $("#delivery_address").val(data.features[0].place_name)
        })
    }


    
    function get_distance(longtitude,latitute){
        var shortest_distance = [];
        store_list.data.features.map((item)=>{

        var from = turf.point([longtitude,latitute]);
        var to = turf.point(item.geometry.coordinates);
        var options = {units: 'kilometers'};
        var distance = turf.distance(from, to, options);

        shortest_distance.push(
            {
                kl:distance,
                id:item.geometry.id,
                shop_name:item.geometry.shop_name
            }
        );

        })

        shortest_distance = shortest_distance.sort((a, b) => {
            if (a.kl < b.kl) {
                return -1;
            }
            });

        $("#storelist").empty();
        shortest_distance.map((item)=>{
            $("#storelist").append("<option value="+item.id+">"+item.shop_name+"</option>");
        })
       
    }




</script>