<?php
require_once('./../../config.php');
$product_list_table = $_settings->userdata('is_supplier') == 1 ? "product_list_vendor" : "product_list";
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT p.*, c.name as `category` from `$product_list_table` p inner join category_list c on p.category_id = c.id where p.id = '{$_GET['id']}' and p.delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
?>
		<center>Unknown Category</center>
		<style>
			#uni_modal .modal-footer{
				display:none
			}
		</style>
		<div class="text-right">
			<button class="btn btndefault bg-gradient-dark btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
		</div>
		<?php
		exit;
		}
}
?>
<style>
	#uni_modal .modal-footer{
		display:none
	}
	#prod-img-view{
		width:15em;
		max-height:20;
		object-fit:scale-down;
		object-position: center center;
	}
</style>
<div class="container-fluid">
	<center><img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="Product Image" class="img-thubmnail p-0 bg-gradient-green" id="prod-img-view"></center>
	
	<div class="row mt-2">
		<div class="col">
			<dl>
				<dt class="text-muted">Product</dt>
				<dd class="pl-3"><?= isset($name) ? $name : "" ?></dd>
				<dt class="text-muted">Category</dt>
				<dd class="pl-3"><?= isset($category) ? $category : "" ?></dd>
				<dt class="text-muted">Price</dt>
				<dd class="pl-3"><?= isset($price) ? format_num($price) : "" ?></dd>
				<dt class="text-muted">Description</dt>
				<dd class="pl-3"><?= isset($description) ? html_entity_decode($description) : "" ?></dd>
				<dt class="text-muted">Limit Per Day</dt>
				<dd class="pl-3"><?= isset($limit_per_day) ? format_num($limit_per_day) : "0" ?></dd>
				<dt class="text-muted">Status</dt>
				<dd class="pl-3">
					<?php if($status == 1): ?>
						<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Avaiable</span>
					<?php else: ?>
						<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Not Avaiable</span>
					<?php endif; ?>
				</dd>
			</dl>
		</div>
		<div class="col">
		
		<?php

			$orderitem = "";
			$userlist = "";
			$where = "";
			if($_settings->userdata('is_supplier') == 0){
				$orderitem = "order_items";
				$userlist = "client_list";
			}
			else{
				$orderitem = "order_items_vendor";
				$userlist = "vendor_list";
				$where = " and is_supplier = 0";
			}

                            $get_ratings = $conn->query("SELECT a.*,b.firstname,b.lastname from `$orderitem` a left join `$userlist` b on a.client_id = b.id where  product_id = '{$_GET['id']}' $where ");
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
                                    $list_item.='<small>Variant: '.ucfirst($type[0])." ".strtoupper($type[1]).'</small>';
                                    $list_item.='</div>';
                                    $list_item.='<p class="mb-1">'.$row["feedback"].'</p>';
                                    $list_item.='<small>'.date("F d, Y g:i:s a",strtotime($row['date_inserted'])).'</small>';
                                    $list_item.='</a><br>';
                                }

                                
                                }
                        
                            
                        ?>
                        <div class="d-flex align-items-center">
                            <h4>Ratings: </h4>
                            <span class="ml-2" style="font-size: 20px;margin-top: -5px;"><?= number_format($total_rating/$ctr,2) ?></span>
                        </div>
                        <h5>Feedback</h5>
                        <div class="list-group" style="max-height: 400px;overflow-y: auto;">
                            <?=$list_item?>
                        </div>
                        <?php } ?>
		</div>
	</div>
	
	
	

	<div class="clear-fix mb-3"></div>
	<div class="text-right">
		<button class="btn btn-default bg-gradient-dark btn-sm btn-flat" type="button" data-dismiss="modal"><i class="fa f-times"></i> Close</button>
	</div>
</div>
