<?php

	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("set names UTF8");
	$msg = (object)[];
	$login_id =$_GET["id"] ;
	
	if($stmt = $link->prepare('SELECT id, account, nick, email, sex, address, phone FROM member WHERE id = ?')){
		$stmt->bind_param('i',$login_id);
		$stmt->execute();
		$stmt->bind_result($mem_id, $mem_account, $mem_nick, $mem_email, $mem_sex, $mem_address, $mem_phone);
		$stmt->store_result();
		
		while ($stmt->fetch()) {
				echo $mem_id. '<br>'. $mem_account. '<br>' .$mem_nick. '<br>' .$mem_email. '<br>'. $mem_sex. '<br>' .$mem_address. '<br>' .$mem_phone . '<br>';
			
				}
	
	}
		
?>