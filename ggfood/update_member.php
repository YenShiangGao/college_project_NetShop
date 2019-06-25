<?php
	session_start();
	$msg = (object)[];
	if(isset($_SESSION)&&isset($_SESSION['id'])){
		//連接資料庫
		$link = mysqli_connect('localhost','root')or die('error connection');
		$link->select_db('ggfood');
		$link->query("set names UTF8");
		
		$escape = function($str) use(&$link){
			return mysqli_real_escape_string($link,$str);
		};
		
		//檢查資料是否更新
		$set = ''; 
		$count = 0;
		if(isset($_POST['nick'])){
			$count += 1;
			$set .= "nick = '{$escape($_POST['nick'])}' ";
		}
		if(isset($_POST['phone'])){
			if($count > 0)
				$set .= ',';
			$count += 1;
			$set .= "phone = '{$escape($_POST['phone'])}' ";
		}
		if(isset($_POST['email'])){
			if($count > 0)
				$set .= ',';
			$count += 1;
			$set .= "email = '{$escape($_POST['email'])}' ";
		}
		if(isset($_POST['address'])){
			if($count > 0)
				$set .= ',';
			$count += 1;
			$set .= "address = '{$escape($_POST['address'])}' ";
		}
		$sql = "UPDATE member SET $set WHERE id = {$_SESSION['id']}";
		if($link->query($sql)){
			$msg->code = 0;
			$msg->msg = "更新成功!!";
		}else{
			$msg->code = 1;
			$msg->msg = "更新失敗!!  $sql {$_SESSION['id']}";
		}
		echo json_encode($msg);
		$link->close();
	}else{
		$msg->code = 2;
		$msg->msg = "尚未登入";
		echo json_encode($msg);
	}
?>

	