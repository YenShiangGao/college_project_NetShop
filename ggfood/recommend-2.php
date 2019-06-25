<?php
	$dbhost='localhost';
	$dbuser='ggfoodli_normal';
	$dbpassword='gg12345678';
	$dbname='ggfoodli_ggfood';
	$link =mysqli_connect($dbhost,$dbuser,$dbpassword) or die('error connection');
	mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,$dbname);
	$sql="SELECT COUNT(*) FROM recipe";
	$result=mysqli_query($link, $sql);
	$count=mysqli_fetch_assoc($result);
	$ran=rand(0,$count["COUNT(*)"]);
	$sql="SELECT * FROM recipe where id=$ran";
	$result=mysqli_query($link, $sql);
	$data=mysqli_fetch_assoc($result);
	echo json_encode($data);
	
?>