<?php
function &get_link(){
	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("SET NAMES UTF8");
	return $link;
}
?>
