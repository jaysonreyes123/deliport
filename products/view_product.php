<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT  p.*, v.shop_name as vendor, c.name as `category` FROM `product_list` p inner join vendor_list v on p.vendor_id = v.id inner join category_list c on p.category_id = c.id where p.delete_flag = 0 and p.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo "<script> alert('Unkown Product ID.'); location.replace('./?page=products') </script>";
        exit;
    }
}else{
    echo "<script> alert('Product ID is required.'); location.replace('./?page=products') </script>";
    exit;
}
?>
<style>
    #prod-img-holder {
        height: 45vh !important;
        width: calc(100%);
        overflow: hidden;
    }

    #prod-img {
        object-fit: scale-down;
        height: calc(100%);
        width: calc(100%);
        transition: transform .3s ease-in;
    }
    #prod-img-holder:hover #prod-img{
        transform:scale(1.2);
    }
    .active{
        background: #0069d9;
        color: white;
    }
    .active:hover{
        background: #0069d9;
        color: white;
    }
    .jq-ry-container{
        padding:0px !important;
    }
</style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h5 class="card-title"><b>Product Details</b></h5>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div id="msg"></div>
                <div class="row">
                    <div class="col-lg-3 col-md-5 col-sm-12 text-center">
                        <div class="position-relative overflow-hidden" id="prod-img-holder">
                            <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="<?= $row['name'] ?>" id="prod-img" class="img-thumbnail bg-gradient-green">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 col-sm-12">
                        <h3><b><?= $name ?></b></h3>
                        <div class="d-flex w-100">
                            <div class="col-auto px-0"><small class="text-muted">Vendor: </small></div>
                            <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0"><small class="text-muted"><?= $vendor ?></small></p></div>
                        </div>
                        <div class="d-flex">
                            <div class="col-auto px-0"><small class="text-muted">Category: </small></div>
                            <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0"><small class="text-muted"><?= $category ?></small></p></div>
                        </div>
                       
                        <div class="d-flex mb-2 mt-2">
                            <div class="col-auto px-0"><small class="text-muted">Bilao: </small></div>
                            <?php if($bilao_piece_s > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="bilao_s" data-stock="<?=$bilao_piece_s?>" data-price="<?=$bilao_cost_s?>" >S</button>
                            <?php endif; ?>
                            <?php if($bilao_piece_m > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="bilao_m" data-stock="<?=$bilao_piece_m?>" data-price="<?=$bilao_cost_m?>" >M</button>
                            <?php endif; ?>
                            <?php if($bilao_piece_l > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="bilao_l" data-stock="<?=$bilao_piece_l?>" data-price="<?=$bilao_cost_l?>">L</button>
                            <?php endif; ?>
                            <?php if($bilao_piece_xl > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="bilao_xl" data-stock="<?=$bilao_piece_xl?>" data-price="<?=$bilao_cost_xl?>">XL</button>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex mb-2">
                            <div class="col-auto px-0"><small class="text-muted">Tub: </small></div>
                            <?php if($tub_piece_s > 0): ?>
                                <button class="btn btn-default py-0 ml-3 order_btn" data-type="tub_s" data-stock="<?=$tub_piece_s?>" data-price="<?=$tub_cost_s?>">S</button>
                            <?php endif; ?>
                            <?php if($tub_piece_m > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="tub_m" data-stock="<?=$tub_piece_m?>" data-price="<?=$tub_cost_m?>">M</button>
                            <?php endif; ?>
                            <?php if($tub_piece_l > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="tub_l" data-stock="<?=$tub_piece_l?>" data-price="<?=$tub_cost_l?>">L</button>
                            <?php endif; ?>
                            <?php if($tub_piece_xl > 0): ?>
                                <button class="btn btn-default py-0 ml-2 order_btn" data-type="tub_xl" data-stock="<?=$tub_piece_xl?>" data-price="<?=$tub_cost_xl?>">XL</button>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex">
                            <div class="col-auto px-0"><small class="text-muted">Stock: </small></div>
                            <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><input style="border: none;" id="stock" type="text" readonly></small></p></div>
                        </div>

                        <div class="d-flex">
                            <div class="col-auto px-0"><small class="text-muted">Price: </small></div>
                            <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><input style="border: none;" id="price" type="text" readonly></small></p></div>
                        </div>
                        
                        
                        <div class="row align-items-end">
                            <div class="col-md-3 form-group">
                                <input type="number" min = "1" id= 'qty' value="1" class="form-control rounded-0 text-center">
                            </div>
                            <div class="col-md-4 form-group">
                                <button class="btn btn-primary btn-flat" type="button" id="add_to_cart"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                        <div class="w-100"><?= html_entity_decode($description) ?></div>
                    </div>
                    <div class="col-lg-4">
                        <?php
                            $get_ratings = $conn->query("SELECT a.*,b.firstname,b.lastname from order_items a left join client_list b on a.client_id = b.id where  product_id = '{$_GET['id']}' ");
                            $total_rating = 0;
                            $ctr =0;
                            $list_item = "";
                            $count  = $get_ratings->num_rows;
                            if($count > 0){
                                while($row = $get_ratings->fetch_assoc()){
                                if($row["rating"] != null){
                                    $total_rating+=$row["rating"];
                                    $ctr++;
                                }   
                                
                                if($row["feedback"]!=""){
                                    $type = explode("_",$row["type"]);
                                    $list_item.='<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">';
                                    $list_item.='<div class="d-flex w-100 justify-content-between">';
                                    $list_item.='<h5 class="mb-1">'.$row["firstname"]." ".$row["lastname"].'</h5>';
                                    $list_item.='<small>Variant: '.ucfirst($type[0])." ".strtoupper($type[1]).'<div class="rate" data-rating="'.$row["rating"].'" ></div></small>';
                                    $list_item.='</div>';
                                    $list_item.='<p class="mb-1">'.$row["feedback"].'</p>';
                                    $list_item.='<small>'.date("F d, Y g:i:s a",strtotime($row['date_inserted'])).'</small>';
                                    $list_item.='</a><br>';
                                }

                                
                                }
                        
                            
                        ?>
                        <div class=" align-items-center">
                            <?php
                                $rating = number_format($total_rating/$ctr,2);
                            ?>
                            <h4>Ratings: <span style="font-size: 20px;margin-top: -5px;"><?= $rating ?></span></h4>
                            <div class="rate_all" data-value="<?=$rating?>"></div>
                            
                        </div>
                        <h5>Feedback</h5>
                        <div class="list-group" style="max-height: 400px;overflow-y: auto;">
                            <?=$list_item?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="type">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    
    var rating = $(".rate_all").data("value");
    $(".rate_all").rateYo({
        rating:rating,
        readOnly:true
    })

    // $(".rate").rateYo({
    //     starWidth:"20px",
    //     readOnly:true

    // });

    $(".rate").each(function(){
        var rating = $(this).data("rating");
        $(this).rateYo({
            rating:rating,
            readOnly:true,
            starWidth:"15px"
        });
    })

    $(".order_btn").click((e)=>{
        $(".order_btn").removeClass('active');
        let price = $(e.target).data('price');
        $(e.target).addClass('active');
        $("#type").val($(e.target).data('type'))
        $("#price").val(price);
        $("#stock").val($(e.target).data('stock'));
    })

    function add_to_cart(){

        if(!$(".order_btn").hasClass("active")){
            alert("Size is required");
            return false;
        }

        var type = $("#type").val();
        var pid = '<?= isset($id) ? $id : '' ?>';
        var qty = $('#qty').val();
        var el = $('<div>')
        el.addClass('alert alert-danger')
        el.hide()
        $('#msg').html('')
        start_loader()
        $.ajax({
            url:_base_url_+'classes/Master.php?f=add_to_cart',
            method:'POST',
            data:{product_id:pid,quantity:qty,price:$("#price").val(),type:type},
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                console.log(resp);
                if(resp.status =='success'){
                    location.reload()
                }else if(!!resp.msg){
                    el.text(resp.msg)
                    $('#msg').append(el)
                    el.show('slow')
                    $('html, body').scrollTop(0)
                }else{
                    el.text("An error occurred. Please try to refresh this page.")
                    $('#msg').append(el)
                    el.show('slow')
                    $('html, body').scrollTop(0)
                }
                end_loader()
            }
        })
    }
    $(function(){
        $('#add_to_cart').click(function(){
            if('<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 3 ?>'){
                add_to_cart();
            }else{
                location.href = "./login.php"
            }
        })
    })
</script>