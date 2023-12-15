<?php
require_once('../config.php');
require_once("../email/config.php");

Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
		extract($_POST);
		$data = '';
		$chk = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id>0 ? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}

		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					$fname = 'uploads/avatar-'.($id).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
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
									$qry = $this->conn->query("UPDATE users set avatar = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$id' ");
								}
						}else{
						$resp['msg']=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}
				return 1;
			}else{
				return 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				foreach($_POST as $k => $v){
					if($k != 'id'){
						if(!empty($data)) $data .=" , ";
						$this->settings->set_userdata($k,$v);
					}
				}
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					$fname = 'uploads/avatar-'.($id).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
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
									$qry = $this->conn->query("UPDATE users set avatar = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$id' ");
									if($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 1)
										$this->settings->set_userdata('avatar',$fname."?v=".(time()));
								}
						}else{
						$resp['msg']=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}

				return 1;
			}else{
				return "UPDATE users set $data where id = {$id}";
			}
			
		}
	}
	public function delete_users(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function save_vendor(){
		if(!empty($_POST['password']))
		$_POST['password'] = md5($_POST['password']);
		else
		unset($_POST['password']);
		if(empty($_POST['id'])){
			$prefix = date('Ym-');
			$code = sprintf("%'.05d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `vendor_list` where code = '{$prefix}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$_POST['code'] = $prefix.$code;
		}
		extract($_POST);
		if($shop_type_id == 6){
			$is_supplier = 0;
		}
		else{
			$is_supplier = 1;
		}
		if(isset($oldpassword) && !empty($id)){
			$current_pass = $this->conn->query("SELECT * FROM `vendor_list` where id = '{$id}'")->fetch_array()['password'];
			if(md5($oldpassword) != $current_pass){
				$resp['status'] = 'failed';
				$resp['msg'] = ' Incorrect Current Password';
				return json_encode($resp);
				exit;
			}
		}
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,['id','cpassword','oldpassword']) && !is_array($_POST[$k])){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=", ";
				if($k == "module"){
					$data.="`is_supplier`='{$is_supplier}'";
				}
				else{
					$data.="`{$k}`='{$v}'";
				}
				
			}
		}
		$check  = $this->conn->query("SELECT * FROM `vendor_list` where username = '{$username}' and delete_flag = 0 ".(!empty($id) ? " and id !='{$id}'" : ''))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Username already exists";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `vendor_list` set {$data}";
			}else{
				$sql = "UPDATE `vendor_list` set {$data} where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = "success";
				$vid = empty($id) ? $this->conn->insert_id : $id;
				if(empty($id)){
					if(strpos($_SERVER['HTTP_REFERER'], 'vendor/register.php') > -1){
						$resp['msg'] = " Your account has been registered successfully.";
					}else{
						$resp['msg'] = " Vendor's Account has been registered successfully.";
					}
				}else{
					if($this->settings->userdata('login_type') == 2){
						$resp['msg'] = " Your account details has been updated successfully.";
					}else{
						$resp['msg'] = " Vendor's Account Details has been updated successfully.";

							$filename = "";
							if($status == 1){
								$filename = "email_vendor_approve.php";
							}
							else if($status ==2){
								
								$filename = "email_vendor_decline.php";
							}	
							ob_start();
							require_once('../email/'.$filename);
							$content = ob_get_contents();
							ob_end_clean();
							$mailer = new Mail();
							$mail = $mailer->mails($username,$content,"Account Declined");
							$mail->send();		
					}	
				}

				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/vendors"))
					mkdir(base_app."uploads/vendors");
					$fname = 'uploads/vendors/'.($vid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg'].=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
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
								if($uploaded_img){
									$qry = $this->conn->query("UPDATE `vendor_list` set avatar = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$vid' ");
									if($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 2)
										$this->settings->set_userdata('avatar',$fname."?v=".(time()));
								}
						}else{
						$resp['msg'].=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}

				if(isset($_FILES['business_permit']) && $_FILES['business_permit']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/permit"))
					mkdir(base_app."uploads/permit");
					$fname = 'uploads/permit/'.($vid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['business_permit']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg'].=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
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
							if($uploaded_img){
								$qry = $this->conn->query("UPDATE `vendor_list` set business_permit = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$vid' ");
								if($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 2)
									$this->settings->set_userdata('business_permit',$fname."?v=".(time()));
							}
					}else{
					$resp['msg'].=" But Image failed to upload due to unkown reason.";
					}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = " An error occure while saving the account details.";
				$resp['error'] = $this->conn->error;
			}
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);

		return json_encode($resp);
	}
	public function delete_vendor(){
		extract($_POST);
		$qry = $this->conn->query("UPDATE vendor_list set delete_flag = 1 where id = $id");
		if($qry){
			$this->settings->set_flashdata('success',' Vendor Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'An error occured while deleting the data.';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function save_client(){
		if(!empty($_POST['password']))
		$_POST['password'] = md5($_POST['password']);
		else
		unset($_POST['password']);
		if(empty($_POST['id'])){
			$prefix = date('Ym-');
			$code = sprintf("%'.05d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `client_list` where code = '{$prefix}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$_POST['code'] = $prefix.$code;
		}
		extract($_POST);
		if(isset($oldpassword) && !empty($id)){
			$current_pass = $this->conn->query("SELECT * FROM `client_list` where id = '{$id}'")->fetch_array()['password'];
			if(md5($oldpassword) != $current_pass){
				$resp['status'] = 'failed';
				$resp['msg'] = ' Incorrect Current Password';
				return json_encode($resp);
				exit;
			}
		}
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,['id','cpassword','oldpassword']) && !is_array($_POST[$k])){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=", ";
				$data.="`{$k}`='{$v}'";
			}
		}
		$check  = $this->conn->query("SELECT * FROM `client_list` where email = '{$email}' and delete_flag = 0 ".(!empty($id) ? " and id !='{$id}'" : ''))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Email already exists";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `client_list` set {$data}";
			}else{
				$sql = "UPDATE `client_list` set {$data} where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = "success";
				$vid = empty($id) ? $this->conn->insert_id : $id;
				if(empty($id)){
					if(strpos($_SERVER['HTTP_REFERER'], 'client/register.php') > -1){
						$resp['msg'] = " Your account has been registered successfully.";
					}else{
						$resp['msg'] = " Customer's Account has been registered successfully.";
					}
				}else{
					if($this->settings->userdata('login_type') == 3){
						$resp['msg'] = " Your account details has been updated successfully.";
					}else{
						$resp['msg'] = " Customer's Account Details has been updated successfully.";
					}	
				}

				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/clients"))
					mkdir(base_app."uploads/clients");
					$fname = 'uploads/clients/'.($vid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg'].=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
							
							
							$email = $_POST['email'];
							
							$user_level = "client";	
							$base_url = base_url;
							ob_start();
							require_once('../email/email_verification.php');
							$content = ob_get_contents();
							ob_end_clean();
							$mailer = new Mail();
							$mail = $mailer->mails($email,$content,"Email Verification");
							$mail->send();
							
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
								if($uploaded_img){



									$qry = $this->conn->query("UPDATE `client_list` set avatar = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$vid' ");
									if($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 2)
										$this->settings->set_userdata('avatar',$fname."?v=".(time()));
								}
						}else{
						$resp['msg'].=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = " An error occure while saving the account details.";
				$resp['error'] = $this->conn->error;
			}
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);

		return json_encode($resp);
	}
	public function delete_client(){
		extract($_POST);
		$qry = $this->conn->query("UPDATE client_list set delete_flag = 1 where id = $id");
		if($qry){
			$this->settings->set_flashdata('success',' Customer Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'An error occured while deleting the data.';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function verify_email($user_level,$email){
		$this->conn->query("UPDATE `$user_level` set status = 1 where email = '$email' ");
		$url = base_url."login.php";
		echo "<script>location.href='".$url."'</script>";
	}
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	case 'save_vendor':
		echo $users->save_vendor();
	break;
	case 'delete_vendor':
		echo $users->delete_vendor();
	break;
	case 'save_client':
		echo $users->save_client();
	break;
	case 'delete_client':
		echo $users->delete_client();
		break;
	case 'verify_email':
		echo $users->verify_email($_GET['user_level']."_list",$_GET['email']);
		break;
	default:
		// echo $sysset->index();
		break;
}