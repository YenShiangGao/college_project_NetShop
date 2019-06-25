<?php
    require_once('get_link.php');
	session_start();
	$msg = (object)[];

	if(isset($_SESSION['id'])){
		if($_SESSION['authority']<2){
	    	$link = get_link();
			
			$escape = function($str) use (&$link){
				return mysqli_real_escape_string($link,$str);
			};
			//p_id產品編號i,price價格i,quantity數量i,description描述s
			//檢查資料是否更新
			$set = ''; 
			if(isset($_POST['p_id'])){
				$field = ['name','price','quantity','description'];
				$ddd = '';
				foreach($field as $key => $val){
					if(isset($_POST[$val])){
						$set .= "$ddd$val='{$escape($_POST[$val])}'";
						$ddd = ',';
					}
				}
				/*比對供應商帳號*/
				$sql = "SELECT uploader_id FROM products WHERE id = {$escape($_POST['p_id'])}";
				$result = $link->query($sql);
				if($result){
					$row = $result->fetch_array();
					$uploaderId = $row[0];
					if($uploaderId == $_SESSION['id']){
						/*更新產品資訊*/
						$sql = "UPDATE products SET $set WHERE id = {$escape($_POST['p_id'])}";
						if($link->query($sql)){
							$msg->code = 0;
							$msg->msg = "更新成功!!";
						}else{
							$msg->code = 1;
							$msg->msg = "更新失敗!!";
						}
					}
				}else{
					$msg->code = 4;
					$msg->msg = "更新失敗!!";
				}
			}else{
				$msg->code = 3;
				$msg->msg = "請先選擇欲修改的產品!!";
			}
			$link->close();
		}
	}else{
		$msg->code = 2;
		$msg->msg = "尚未登入!!";
	}
	echo json_encode($msg);
?>

	