<?php
	session_start();
	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("set names UTF8");
	$login_id=$_GET['id'];
	$preference=$_GET['preference'];
	var_dump($preference);
	if($stmt = $link->prepare('DELETE FROM member_preference WHERE m_id = ?')){
		$stmt->bind_param('i',$login_id);
		$stmt->execute();
		$stmt->store_result();
	}
	foreach($preference as $value){
		if($stmt = $link->prepare("INSERT INTO `ggfood`.`member_preference` (`id`, `m_id`, `preference`) VALUES (NULL, '$login_id', '$value')")){
			$stmt->execute();
			$stmt->store_result();
		}
	}
?>