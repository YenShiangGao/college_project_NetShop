<html>

<head>
<meta charset="utf-8">
</head>
<?php
	$link = mysqli_connect('localhost','root','','ggfood');
	$link->query("SET NAMES 'UTF8'");

	//120.105.161.173
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{
		$recipe = (Object)array();
		$recipe->id= $_GET['recipe'];
		
		$sql = "SELECT * FROM recipe WHERE id = '{$recipe->id}'";
               // echo $sql.'<br>';
		$result = $link->query($sql);
		if ($result = $link->query($sql)) {
                        $row = $result->fetch_assoc();
                             //echo "search_one<br>";
                             echo $row['name'].'<br>';
                             echo "<img width=\"100%\" src=".$row['image']."></img><br>";

			
		} else {
			echo "0 results";
		}
		
		$link->close();
	}
	
	
	
?>
</html>