<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `request_info` where id = '{$_GET['id']}'  ");
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

<div class="container-fluid">
<div class="list-group" style="max-height: 500px;overflow-y: auto;">

</div>
    <form id="request-form">
    	<div class="form-group">
						<label for="supplier_id" class="control-label">Supplier</label>
						<select type="text" id="supplier_id" name="supplier_id" class="form-control form-control-sm form-control-border select2" required>
							<option value="" disabled <?= !isset($supplier_id) ? 'selected' : "" ?>></option>
							<?php 
							$suppliers = $conn->query("SELECT * from vendor_list where is_supplier = 1 and `status` = 1 ");
							while($row = $suppliers->fetch_assoc()):
							?>
							<option value="<?= $row['id'] ?>" <?= isset($supplier_id) && $supplier_id == $row['id'] ? 'selected': '' ?>><?= $row['shop_name'] ?></option>
							<?php endwhile; ?>
						</select>
		</div>

    <input type="hidden" name="seller_id" value="<?=$_settings->userdata('id')?>">
        <input type="hidden" name="id" value="<?=$_GET['id'] ?? ""?>">
        <!-- <input type="hidden" name="supplier_id" value="<?=$_GET['supplier_id'] ?? ""?>"> -->
            <div class="form-group">
                        <label for="request" class="control-label">Request:</label>
                        <textarea name="request" id="request" rows="4"class="form-control form-control-sm rounded-0" required><?php echo isset($request) ? html_entity_decode($request) : ''; ?></textarea>
            </div>
    </form>

</div>
<script>
$("#submit").show();
    $(function(){
        $("#request-form").on('submit',function(e){
            e.preventDefault();
            start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_request",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
				success:function(resp){
					location.reload();

				}
			})
            
        })
    })

</script>