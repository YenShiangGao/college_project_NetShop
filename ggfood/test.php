<?php
/*
	echo 'post :';
	echo var_export($_POST);
	echo 'get :';
	echo var_export($_GET);
	*/
	header("Content-type: application/json");
	$postData = file_get_contents("php://input",'r');
	file_put_contents('file.txt',$postData . '66666666666');
	$obj = (object)[];
	$obj->speech = 'php';
	$obj->displayText = 'php66666';
	echo json_encode($obj);
?>