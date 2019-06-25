<?php
	session_start();
	$msg = (object)[];
	if(isset($POST["acc"]) || isset($_POST["pas"])){
		if($_POST["acc"]==null||$_POST["pas"]==null){
			$msg->code = 1;
			$msg->msg = '欄位不能為空值!!';
			echo json_encode($msg);
			return;
		}
	}
	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("set names UTF8");
	$acc = $_POST["acc"];
	$pas = $_POST["pas"];
	if($stmt = $link->prepare('SELECT * FROM member WHERE account=?')){
		/*
		$stmt->bind_param('s',$acc);
		if(!($stmt->execute())){
			$msg->code = 3;
			$msg->msg = '發生未知的問題';
			echo json_encode($msg);
			$stmt->close();
			return;
		}
		*/
		
		$stmt->bind_param('s',$acc);
		$stmt->execute();
		$stmt->bind_result($r_id,$r_acc,$r_pas,$r_nick ,$r_email, $r_sex, $r_address, $r_phone,$authority);
		$stmt->store_result();
		if($stmt->num_rows <= 0){
			$msg->code = 1;
			$msg->msg = '查無此帳號!!';
		}else{
			while ($stmt->fetch()) {
			
				if($r_pas == $pas){
					$msg->code = 0;
					$msg->msg = "{$r_nick}主人，歡迎回來!!";
					
					$msg->info = (object)[];
					$msg->info->id = $r_id;
					$msg->info->account = $r_acc;
					$msg->info->password = $r_pas;
					$msg->info->nick = $r_nick;
					$msg->info->email = $r_email;
					$msg->info->sex = $r_sex;
					$msg->info->address = $r_address;
					$msg->info->phone = $r_phone;
					$_SESSION['id'] = $r_id;
					break;
				}
			}
			if(!isset($msg->code) || $msg->code !=0){
				$msg->code = 2;
				$msg->msg = '密碼錯誤!!';
			}
		}
	}
	echo json_encode($msg);
	$stmt->free_result();
	$stmt->close();
?>