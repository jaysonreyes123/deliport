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
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Supplies Request</h3>
		<div class="card-tools" style="display: <?=$_settings->userdata('is_supplier') == 1 ? 'none' : '' ?> ;">
			<a href="javascript:void(0)" class="btn btn-flat btn-primary" id="create_new"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="10%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr class="bg-gradient-secondary">
						<?php 
							if($_settings->userdata('is_supplier')== 0):
						?>
						<th>Seller</th>
						<th>Supplier</th>
						<th>Date Created</th>
						<th>Action</th>
						<?php else: ?>
						<th>Seller</th>
						<th>Date Created</th>
						<th>Action</th>
						<?php endif;?>
						
					</tr>
				</thead>
				<tbody>

					<?php 
					$column = $_settings->userdata('is_supplier')  == 0 ? 'seller_id' : 'supplier_id';
					$i = 1;
						$qry = $conn->query("SELECT *,(select shop_name from vendor_list where id = `request_info`.seller_id and is_supplier = 0 ) as seller,
													(select shop_name from vendor_list where id = `request_info`.supplier_id and is_supplier = 1 ) as supplier 
						from `request_info` where `$column` = '{$_settings->userdata('id')}'  ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
                            <td>
                                <?=$row['seller']?>
                            </td>
							<?php if($column == 'seller_id'): ?>
							<td >
                                <?=$row['supplier']?>
                            </td>
							<?php endif;?>
                            <td>
                                <?=$row['date_created']?>
                            </td>
                            <td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?=$row['id']?>"><span class="fa fa-eye text-dark"></span> View</a>
									<?php if($_settings->userdata('is_supplier') == 0):?>
									 <div class="dropdown-divider"></div>
									 <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?=$row['id']?>" data-supplier_id="<?php echo $row['supplier_id']?>"
                                     data-seller_id="<?php echo $row['seller_id']?>" ><span class="fa fa-edit text-dark"></span> Edit</a>
									 <?php endif;?>
				                  </div>
								  
							</td>
						</tr>
					<?php endwhile; ?>


				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		$('#create_new').click(function(){
			uni_modal('Add New Product',"request/manage_request.php",'large')
		})

		$('.view_data').click(function(){
			uni_modal('View Request',"request/view_request.php?id="+$(this).attr('data-id'),'large')
		})

		$('.edit_data').click(function(){
			uni_modal('Update Request',"request/manage_request.php?id="+$(this).attr('data-id'),'large')
		})

		$('.table').dataTable();
	})
</script>