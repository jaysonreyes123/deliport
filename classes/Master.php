<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_shop_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `shop_type_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Shop Type already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `shop_type_list` set {$data} ";
			}else{
				$sql = "UPDATE `shop_type_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Shop Type successfully saved.";
				else
				$resp['msg'] = " Shop Type successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_shop_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `shop_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Shop Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and vendor_id = '{$vendor_id}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Category already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `category_list` set {$data} ";
			}else{
				$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Category successfully saved.";
				else
				$resp['msg'] = " Category successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$product_list_table = $this->settings->userdata('is_supplier') == 1 ? "product_list_vendor" : "product_list";
		$check = $this->conn->query("SELECT * FROM `$product_list_table` where vendor_id = '{$vendor_id}' and `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Product Name Already exists.';
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `$product_list_table` set {$data} ";
			}else{
				$sql = "UPDATE `$product_list_table` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$pid = empty($id) ? $this->conn->insert_id : $id;
				$resp['pid'] = $pid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " New Product successfully saved.";
				else
					$resp['msg'] = " Product successfully updated.";
				
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/products"))
					mkdir(base_app."uploads/products");
					$fname = 'uploads/products/'.($pid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" But Image failed to upload due to invalid file type.";
					}else{
						
				
						list($width, $height) = getimagesize($upload);
						$new_height = $height; 
						$new_width = $width; 
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
								if(isset($uploaded_img) && $uploaded_img == true){
									$qry = $this->conn->query("UPDATE `$product_list_table` set image_path = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$pid' ");
								}
						}else{
						$resp['msg']=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				if(empty($id))
					$resp['msg'] = " Product has failed to save.";
				else
					$resp['msg'] = " Product has failed to update.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}

		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$product_list_table = $this->settings->userdata('is_supplier') == 1 ? "product_list_vendor" : "product_list";
		$del = $this->conn->query("UPDATE `$product_list_table` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function add_to_cart_vendor(){
		$_POST['client_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM cart_list_vendor where product_id = '{$product_id}' && client_id = '{$client_id}' and `type` = '{$type}' ")->num_rows;
		if($check > 0){
			$sql = "UPDATE cart_list_vendor set quantity = quantity + {$quantity},price='{$price}' where product_id = '{$product_id}' && client_id = '{$client_id}' and `type` = '{$type}' ";
		}else{
			$sql = "INSERT INTO cart_list_vendor set {$data}";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$resp['msg'] = " Product has added to cart.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " The product has failed to add to the cart.";
			$resp['error'] = $this->conn->error. "[{$sql}]";
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function update_cart_qty_vendor(){
		extract($_POST);
		$update_cart = $this->conn->query("UPDATE `cart_list_vendor` set `quantity` = '{$quantity}' where id = '{$cart_id}'");
		if($update_cart){
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has updated successfully';
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has failed to update';
			$resp['error'] = $this->conn->error;
		}
		
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_cart_vendor(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `cart_list_vendor` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$resp['msg'] = " Cart Item has been deleted successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Cart Item has failed to delete.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] =='success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function place_order_vendor(){
		extract($_POST);
		$inserted=[];
		$has_failed=false;

		$get_product = $this->conn->query("SELECT * from cart_list_vendor where client_id = '{$this->settings->userdata('id')}' ");
		$date = date("Y-m-d");
		$bool = true;
		$product_name = array();
		$tot_quantity = 0;
		$limit_day = 0;
		while($row = $get_product->fetch_assoc()){
			$quantity = $row['quantity'];
			$tot_quantity+=$quantity;
			$pid = $row['product_id'];
			$type = explode("_",$row["type"]);
			$type_ = $type[0]."_piece_".$type[1];
			$get_qty = $this->conn->query("SELECT * from product_list_vendor where id = $pid ");
			$get_qty_ = $get_qty->fetch_array();
			$limit_day = $get_qty_["limit_per_day"];

			if($quantity > $get_qty_[$type_]){
				$bool = false;
				$product_name[] = $get_qty_["name"]." ".ucfirst($type[0])."(".strtoupper($type[1]).")";
			}
			
		}

		$today = date("Y-m-d");
		$get_order_day = $this->conn->query("SELECT sum(quantity) as quantity from order_items_vendor where date(date_created) = '$today'  ");
		$get_order_day__ = $get_order_day->fetch_array();
		if($method == 1){
			if($get_order_day__["quantity"] > $limit_day){
				$bool = false;
			}
		}


		if($bool){
		$gtotal = 0;
				$vendors = $this->conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list_vendor where id in (SELECT product_id FROM `cart_list_vendor` where client_id ='{$this->settings->userdata('id')}')) order by `shop_name` asc");
				$prefix = date('Ym-');
				$code = sprintf("%'.05d",1);
				while($vrow = $vendors->fetch_assoc()):
					$data = "";
					while(true){
						$check = $this->conn->query("SELECT * FROM order_list_vendor where code = '{$prefix}{$code}' ")->num_rows;
						if($check > 0){
							$code = sprintf("%'.05d",ceil($code) + 1);
						}else{
							break;
						}
					}
					
					$ref_code = $prefix.$code;
				
					$data = "('{$ref_code}','{$this->settings->userdata('id')}','{$storelist}','{$this->conn->real_escape_string($delivery_address)}','{$option}','{$deliverydate}','{$method}','{$delivery_fee}')";
					$sql = "INSERT INTO `order_list_vendor` (`code`,`client_id`,`vendor_id`,`delivery_address`,`option`,`deliverydate`,`method`,`delivery_fee`) VALUES {$data}";
					$save = $this->conn->query($sql);
					if($save){
						$oid = $this->conn->insert_id;
						$inserted[] = $oid;           
						$data = "";
						$gtotal = 0 ;
						$products = $this->conn->query("SELECT c.*, p.name as `name`, c.price,p.image_path,p.id as pid FROM `cart_list_vendor` c inner join product_list_vendor p on c.product_id = p.id where c.client_id = '{$this->settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}' order by p.name asc");
						while($prow = $products->fetch_assoc()):
							$type = explode("_",$prow["type"]);
							$type_ = $type[0]."_piece_".$type[1];
							$this->conn->query("update product_list_vendor set `$type_`= `$type_` - {$prow['quantity']} where id = {$prow['pid']}  ");
							$total = $prow['price'] * $prow['quantity'];
							$gtotal += $total;
							if(!empty($data)) $data .= ", ";
								$data .= "('{$oid}', '{$prow['product_id']}', '{$prow['quantity']}', '{$prow['price']}','{$prow['type']}','{$this->settings->userdata('id')}')";
						endwhile;
						$sql2 = "INSERT INTO `order_items_vendor` (`order_id`,`product_id`,`quantity`,`price`,`type`,`client_id`) VALUES {$data}";
						$save2= $this->conn->query($sql2);
						if($save2){
							$this->conn->query("UPDATE `order_list_vendor` set `total_amount` = '{$gtotal}' where id = '{$oid}'");
						}else{
							$has_failed = true;
							$resp['sql'] = $sql2;
							break;
						}
					}else{
						$has_failed = true;
						$resp['sql'] = $sql;
						break;
					}
				endwhile;
				if(!$has_failed){
					$resp['status'] = 'success';
					$resp['msg'] = " Order has been placed";
					$this->conn->query("DELETE FROM `cart_list_vendor` where client_id ='{$this->settings->userdata('id')}'");
				}else{
					$resp['status'] = 'failed';
					$resp['msg'] = " Order has failed to place";
					$resp['error'] = $this->conn->error;
					if(count($inserted) > 0){
						$this->conn->query("DELETE FROM `order_list_vendor` where id in (".(implode(',',array_values($inserted))).") ");
					}
				}
				if($resp['status'] == 'success')
				$this->settings->set_flashdata('success',$resp['msg']);

		}
		else{
			$resp['status'] = 'failed';
			if(count($product_name) > 0){
				$resp['msg'] = " ".implode(' and ',$product_name)." exceed the limit";
			}
			else{
				$resp['msg'] = "reach the limit for today";
			}
			
		}
		
		

		return json_encode($resp);
	}
	function add_to_cart(){
		$_POST['client_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM cart_list where product_id = '{$product_id}' && client_id = '{$client_id}' and `type` = '{$type}' ")->num_rows;
		if($check > 0){
			$sql = "UPDATE cart_list set quantity = quantity + {$quantity},price='{$price}' where product_id = '{$product_id}' && client_id = '{$client_id}' and `type` = '{$type}' ";
		}else{
			$sql = "INSERT INTO cart_list set {$data}";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$resp['msg'] = " Product has added to cart.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " The product has failed to add to the cart.";
			$resp['error'] = $this->conn->error. "[{$sql}]";
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function update_cart_qty(){
		extract($_POST);
		$update_cart = $this->conn->query("UPDATE `cart_list` set `quantity` = '{$quantity}' where id = '{$cart_id}'");
		if($update_cart){
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has updated successfully';
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = ' Product Quantity has failed to update';
			$resp['error'] = $this->conn->error;
		}
		
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_cart(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `cart_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$resp['msg'] = " Cart Item has been deleted successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Cart Item has failed to delete.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] =='success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function place_order(){
		extract($_POST);
		$inserted=[];
		$has_failed=false;

		$get_product = $this->conn->query("SELECT * from cart_list where client_id = '{$this->settings->userdata('id')}' ");
		$date = date("Y-m-d");
		$bool = true;
		$product_name = array();
		$tot_quantity = 0;
		$limit_day = 0;
		while($row = $get_product->fetch_assoc()){
			$quantity = $row['quantity'];
			$tot_quantity+=$quantity;
			$pid = $row['product_id'];
			$type = explode("_",$row["type"]);
			$type_ = $type[0]."_piece_".$type[1];
			$get_qty = $this->conn->query("SELECT * from product_list where id = $pid ");
			$get_qty_ = $get_qty->fetch_array();
			$limit_day = $get_qty_["limit_per_day"];

			if($quantity > $get_qty_[$type_]){
				$bool = false;
				$product_name[] = $get_qty_["name"]." ".ucfirst($type[0])."(".strtoupper($type[1]).")";
			}
			
		}
		$today = date("Y-m-d");
		$get_order_day = $this->conn->query("SELECT sum(quantity) as quantity from order_items where date(date_created) = '$today'  ");
		$get_order_day__ = $get_order_day->fetch_array();
		if($method == 1){
			if($get_order_day__["quantity"] > $limit_day){
				$bool = false;
			}
		}


		if($bool){
		$gtotal = 0;
				$vendors = $this->conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$this->settings->userdata('id')}')) order by `shop_name` asc");
				$prefix = date('Ym-');
				$code = sprintf("%'.05d",1);
				while($vrow = $vendors->fetch_assoc()):
					$data = "";
					while(true){
						$check = $this->conn->query("SELECT * FROM order_list where code = '{$prefix}{$code}' ")->num_rows;
						if($check > 0){
							$code = sprintf("%'.05d",ceil($code) + 1);
						}else{
							break;
						}
					}
					
					$ref_code = $prefix.$code;
				
					$data = "('{$ref_code}','{$this->settings->userdata('id')}','{$storelist}','{$this->conn->real_escape_string($delivery_address)}','{$option}','{$deliverydate}','{$method}','{$delivery_fee}')";
					$sql = "INSERT INTO `order_list` (`code`,`client_id`,`vendor_id`,`delivery_address`,`option`,`deliverydate`,`method`,`delivery_fee`) VALUES {$data}";
					$save = $this->conn->query($sql);
					if($save){
						$oid = $this->conn->insert_id;
						$inserted[] = $oid;           
						$data = "";
						$gtotal = 0 ;
						$products = $this->conn->query("SELECT c.*, p.name as `name`, c.price,p.image_path,p.id as pid FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$this->settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}' order by p.name asc");
						while($prow = $products->fetch_assoc()):
							$type = explode("_",$prow["type"]);
							$type_ = $type[0]."_piece_".$type[1];
							$this->conn->query("update product_list set `$type_`= `$type_` - {$prow['quantity']} where id = {$prow['pid']}  ");
							$total = $prow['price'] * $prow['quantity'];
							$gtotal += $total;
							if(!empty($data)) $data .= ", ";
								$data .= "('{$oid}', '{$prow['product_id']}', '{$prow['quantity']}', '{$prow['price']}','{$prow['type']}','{$this->settings->userdata('id')}')";
						endwhile;
						$sql2 = "INSERT INTO `order_items` (`order_id`,`product_id`,`quantity`,`price`,`type`,`client_id`) VALUES {$data}";
						$save2= $this->conn->query($sql2);
						if($save2){
							$this->conn->query("UPDATE `order_list` set `total_amount` = '{$gtotal}' where id = '{$oid}'");
						}else{
							$has_failed = true;
							$resp['sql'] = $sql2;
							break;
						}
					}else{
						$has_failed = true;
						$resp['sql'] = $sql;
						break;
					}
				endwhile;
				if(!$has_failed){
					$resp['status'] = 'success';
					$resp['msg'] = " Order has been placed";
					$this->conn->query("DELETE FROM `cart_list` where client_id ='{$this->settings->userdata('id')}'");
				}else{
					$resp['status'] = 'failed';
					$resp['msg'] = " Order has failed to place";
					$resp['error'] = $this->conn->error;
					if(count($inserted) > 0){
						$this->conn->query("DELETE FROM `order_list` where id in (".(implode(',',array_values($inserted))).") ");
					}
				}
				if($resp['status'] == 'success')
				$this->settings->set_flashdata('success',$resp['msg']);

		}
		else{
			$resp['status'] = 'failed';
			if(count($product_name) > 0){
				$resp['msg'] = " ".implode(' and ',$product_name)." exceed the limit";
			}
			else{
				$resp['msg'] = "reach the limit for today";
			}
			
		}
		
		

		return json_encode($resp);
	}
	function cancel_order(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order_list` set `status` = 5 where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been cancelled successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order_list` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has been updated successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has failed to update.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')


		$this->conn->query("INSERT INTO `notification` (order_id,product_id,client_id,vendor_id,`status`) select id,(select product_id from order_items where order_id = order_list.id ),client_id,vendor_id,'$status' from order_list where id = '{$id}'  ");
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	function update_status_vendor(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order_list_vendor` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has been updated successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has failed to update.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')


		$this->conn->query("INSERT INTO `notification` (order_id,product_id,client_id,vendor_id,`status`) select id,(select product_id from order_items where order_id = order_list.id ),client_id,vendor_id,'$status' from order_list where id = '{$id}'  ");
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	public function submit_feedback(){
		extract($_POST);

		// $this->conn->query("UPDATE order_list set rate = '$rating',feedback='$feedback' where id = '$id' ");
		$date = date("Y-m-d H:i:s");
		foreach($_POST as $key =>$val){
			$key_ = explode("_",$key);
			
			$this->conn->query("UPDATE order_items set `{$key_[0]}` = '{$val}',date_inserted='{$date}' where id = '{$key_[1]}' ");
		}
		$resp['status'] = 'success';
		$resp['msg'] = " Feedback has been updated successfully.";
		return json_encode($resp);

	}




	public function submit_feedback_vendor(){
		extract($_POST);

		// $this->conn->query("UPDATE order_list set rate = '$rating',feedback='$feedback' where id = '$id' ");
		$date = date("Y-m-d H:i:s");
		foreach($_POST as $key =>$val){
			$key_ = explode("_",$key);
			
			$this->conn->query("UPDATE order_items_vendor set `{$key_[0]}` = '{$val}',date_inserted='{$date}' where id = '{$key_[1]}' ");
		}
		$resp['status'] = 'success';
		$resp['msg'] = " Feedback has been updated successfully.";
		return json_encode($resp);

	}
	function cancel_order_vendor(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order_list_vendor` set `status` = 5 where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been cancelled successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	public function update_notification(){
		extract($_GET);

		$this->conn->query("UPDATE notification set is_read = 1 where client_id = '$id' ");
		$resp['status'] = 'success';
		$resp['msg'] = " Feedback has been updated successfully.";
		return json_encode($resp);

	}

	public function save_request(){
		$_POST['request'] = htmlentities($_POST['request']);
		extract($_POST);
		if(empty($id)){
			$this->conn->query("INSERT into request_info (seller_id,supplier_id,request) values ('$seller_id','$supplier_id','$request') ");
		}
		else{
			$this->conn->query("UPDATE  request_info set supplier_id = '$supplier_id',request='$request' where id = '$id' ");
		}
		
	}

	public function save_coordinates(){
		extract($_POST);
		$this->conn->query("update vendor_list set coordinates='{$coordinates}' where id = '{$id}' ");
		$this->settings->set_userdata('coordinates',$coordinates);
	}

	public function store_list(){
		$sql = $this->conn->query("SELECT * from vendor_list where is_supplier = 0 and coordinates is not null ");
		// $output = array();
		// while($row = $sql->fetch_assoc()){
		// 	$data = array();
		// 	$data['coordinates'] = explode(",",$row['coordinates']);
		// 	$data['name'] = $row['shop_name'];

		// 	$output[] = $data;
		// }

		// return json_encode($output);
		$data = array();
		while($row = $sql->fetch_assoc()){
			$data[] = array(
				"type" => "Feature",
				"properties"=> array("description"=>$row["shop_name"]),
				"geometry" => array("type" => "Point",
									"coordinates" => array_reverse(explode(",",$row["coordinates"])),
									"id" => $row["id"],
									"shop_name" => $row["shop_name"]
									)
			);
		}

		$geojson = array(
			"type" => "geojson",
			"data" => array(
				"type" => "FeatureCollection",
				"features" => $data
			)
			
		);
		
		return json_encode($geojson,JSON_PRETTY_PRINT);
	}

	public function store_list_vendor(){
		$sql = $this->conn->query("SELECT * from vendor_list where is_supplier = 1 and coordinates is not null ");
		// $output = array();
		// while($row = $sql->fetch_assoc()){
		// 	$data = array();
		// 	$data['coordinates'] = explode(",",$row['coordinates']);
		// 	$data['name'] = $row['shop_name'];

		// 	$output[] = $data;
		// }

		// return json_encode($output);
		$data = array();
		while($row = $sql->fetch_assoc()){
			$data[] = array(
				"type" => "Feature",
				"properties"=> array("description"=>$row["shop_name"]),
				"geometry" => array("type" => "Point",
									"coordinates" => array_reverse(explode(",",$row["coordinates"])),
									"id" => $row["id"],
									"shop_name" => $row["shop_name"]
									)
			);
		}

		$geojson = array(
			"type" => "geojson",
			"data" => array(
				"type" => "FeatureCollection",
				"features" => $data
			)
			
		);
		
		return json_encode($geojson,JSON_PRETTY_PRINT);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_shop_type':
		echo $Master->save_shop_type();
	break;
	case 'delete_shop_type':
		echo $Master->delete_shop_type();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
	break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
	break;
	case 'delete_cart':
		echo $Master->delete_cart();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'cancel_order':
		echo $Master->cancel_order();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'submit_feedback':
		echo $Master->submit_feedback();
	break;
	case 'update_notification':
		echo $Master->update_notification();
	break;
	case 'save_request':
		echo $Master->save_request();
	break;

	case 'save_coordinates':
		echo $Master->save_coordinates();
	break;

	case 'store_list':
		echo $Master->store_list();
	break;

	//vendor order
	case 'add_to_cart_vendor':
		echo $Master->add_to_cart_vendor();
	break;
	case 'update_cart_qty_vendor':
		echo $Master->update_cart_qty_vendor();
	break;
	case 'delete_cart_vendor':
		echo $Master->delete_cart_vendor();
	break;

	case 'store_list_vendor':
		echo $Master->store_list_vendor();
	break;

	case 'place_order_vendor':
		echo $Master->place_order_vendor();
	break;
	case 'update_status_vendor':
		echo $Master->update_status_vendor();
	break;
	case 'submit_feedback_vendor':
		echo $Master->submit_feedback_vendor();
	break;
	case 'cancel_order_vendor':
		echo $Master->cancel_order_vendor();
	break;

	default:
		// echo $sysset->index();
		break;
}