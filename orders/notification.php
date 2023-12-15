<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
                <h5 class="card-title"><b>Notification</b></h5>

                <div class="card-body">
                    <div class="w-100 overflow-auto">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $result = $conn->query("SELECT * from `notification` where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_created) desc ");
                                    while($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                <td>
                                    <?php 
                                    $get_product = $conn->query("SELECT `name` from product_list where id = '{$row['product_id']}' limit 1  ");
                                            $get_product_ = $get_product->fetch_assoc();
                                    echo $get_product_['name'];
                                     ?>
                                </td>
                                <td class="px-2 py-1 align-middle text-center">
                            <?php 
                                switch($row['status']){
                                    case 0:
                                        echo '<span class="badge badge-secondary bg-gradient-secondary px-3 rounded-pill">Pending</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">Confirmed</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Packed</span>';
                                        break;
                                    case 3:
                                        echo '<span class="badge badge-warning bg-gradient-warning px-3 rounded-pill">Out for Delivery</span>';
                                        break;
                                    case 4:
                                        echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Delivered</span>';
                                        break;
                                    case 5:
                                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Cancelled</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
                                        break;
                                }
                            ?>
                        </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<input type="hidden" name="id" value="<?=$_settings->userdata('id')?>" id="id">
<script>
    const id = $("#id").val();
    $(function(){
        update_notification();
        $('table').dataTable();
    })



    function update_notification(){
        $.get(_base_url_+"classes/Master.php?f=update_notification",{id:id}).done(function(data){
                const result = JSON.parse(data);
                if(result.status == "success"){
                    $("#notification_count").text("0");
                }
        })
    }

</script>