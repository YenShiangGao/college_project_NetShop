<?php
    require_once('get_link.php');
	session_start();
	$msg = (object)[];
	if(isset($_SESSION['id'])){
		//連接資料庫
		$link = get_link();
		$escape = function($str) use (&$link){
			return mysqli_real_escape_string($link,$str);
		};
		
		//檢查資料是否更新
		$set = ''; 
		if(isset($_POST['nick'])){
			$set .= "nick = {$escape($_POST['nick'])} ";
		}
		if(isset($_POST['phone'])){
			$set .= "phone = {$escape($_POST['phone'])} ";
		}
		if(isset($_POST['email'])){
			$set .= "email = {$escape($_POST['email'])} ";
		}
		if(isset($_POST['address'])){
			$set .= "address = {$escape($_POST['address'])} ";
		}
		$sql = "UPDATE member SET $set WHERE id = {$_SESSION['id']}";
		if($link->query($sql)){
			$msg->code = 0;
			$msg->msg = "更新成功!!";
		}else{
			$msg->code = 1;
			$msg->msg = "更新失敗!!";
		}
		echo json_encode($msg);
		$link->close();
	}else{
		$msg->code = 2;
		$msg->msg = "尚未登入";
		echo json_encode($msg);
	}
?>

	