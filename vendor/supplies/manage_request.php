<?php
require_once('./../../config.php');
?>

<div class="container-fluid">
<div class="list-group" style="max-height: 500px;overflow-y: auto;">
<?php
    $sql = $conn->query("SELECT * from request_info where product_id='{$_GET['id']}' and supplier_id = '{$_GET['supplier_id']}' order by unix_timestamp(date_created) desc ");
    while($row = $sql->fetch_assoc()):
?>


  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <p class="mb-1"><?=$row['request']?></p>
    <small class="float-right"><?=$row['date_created']?></small>
  </a>


<?php endwhile; ?>
</div>
    <form id="request-form">
    <input type="hidden" name="seller_id" value="<?=$_settings->userdata('id')?>">
        <input type="hidden" name="product_id" value="<?=$_GET['id']?>">
        <input type="hidden" name="supplier_id" value="<?=$_GET['supplier_id']?>">
            <div class="form-group">
                        <label for="request" class="control-label">Request:</label>
                        <textarea name="request" id="request" rows="4"class="form-control form-control-sm rounded-0" required><?php echo isset($request) ? html_entity_decode($request) : ''; ?></textarea>
            </div>
    </form>

</div>
<script>

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