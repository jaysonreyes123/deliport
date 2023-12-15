<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *,(select shop_name from vendor_list where id = `request_info`.seller_id  ) as 'seller',
                                  (select shop_name from vendor_list where id = `request_info`.supplier_id  and is_supplier = 1 ) as 'supplier'
     from `request_info` where id = '{$_GET['id']}'  ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
?>
		<center>Unknown Shop Type</center>
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
	#prod-img-view{
		width:15em;
		max-height:20;
		object-fit:scale-down;
		object-position: center center;
	}
</style>

<div class="container-fluid">
    <div class="row">

      <div class="col-md-2"><?= $_settings->userdata('is_supplier') == 0 ? 'Supplier' : 'Seller' ?>:</div>
      <div class="col"><?=$_settings->userdata('is_supplier') == 0  ? $supplier : $seller  ?></div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-2">Request:</div>
      <div class="col"><?=$request?></div>
    </div>
</div>

<script>
  $("#submit").hide();
</script>