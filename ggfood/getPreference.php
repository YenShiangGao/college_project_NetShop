<?php
	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("set names UTF8");
	$msg = (object)[];
	$login_id =$_GET["id"] ;
	
	if($stmt = $link->prepare('SELECT preference FROM member_preference WHERE m_id = ?')){
		$stmt->bind_param('i',$login_id);
		$stmt->execute();
		$stmt->bind_result($preference);
		$stmt->store_result();
		$stmt->fetch();
        echo $preference;
		while ($stmt->fetch()) {
				echo ",$preference";
				}
	}
?>