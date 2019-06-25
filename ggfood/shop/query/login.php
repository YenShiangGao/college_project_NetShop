<?php
	require_once('get_link.php');
	session_start();
	
	if(!isset($_POST["acc"]) || !isset($_POST["pas"]))return;
	
	$link = get_link();
	$acc = $_POST["acc"];
	$pas = $_POST["pas"];
	//echo $acc . '....' . $pas . '<br>';
	$msg = (object)[];
	
	
	// 防止SQL側注
	if($stmt = $link->prepare('SELECT id,password,nick,authority FROM member WHERE account=?')){
		$stmt->bind_param('s',$acc);
		$stmt->execute();
		$stmt->bind_result($r_id,$r_pas,$r_nick,$r_authority);
		$stmt->store_result();
		
		
		if($stmt->num_rows <= 0){
			$msg->code = 1;
			$msg->msg = '查無此帳號';
		}else{
			while ($stmt->fetch()) {
				if($r_pas == $pas){
					$msg->code = 0;
					$msg->msg = "{$r_nick}主人，歡迎回來";
					
					$msg->info = (object)[];
					$msg->info->id = $r_id;
					$msg->info->nick = $r_nick;
                    $msg->info->authority = $r_authority;
                    
					$_SESSION['id'] = $r_id;
					$_SESSION['authority'] = $r_authority;
					break;
				}
			}
			if(!isset($msg->code) || $msg->code !=0){
				$msg->code = 2;
				$msg->msg = '密碼錯誤';
			}
		}
	}
	echo json_encode($msg);
	$stmt->free_result();
	$stmt->close();
	$link->close();
?>