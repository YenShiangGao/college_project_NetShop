<?php
	$link = mysqli_connect('localhost','root','','ggfood');
	$link->query("SET NAMES 'UTF8'");
	//120.105.161.173
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{
		$recipe = (Object)array();
		
		$recipe->categories = $_GET['categories'];
		$recipe->name = $_GET['recipe'];
		$recipe->ingredients = $_GET['ingredients'];
		
		if($recipe->ingredients!=""||$recipe->categories!=""){
			if($recipe->name!=""){
				//食材 + 食譜名稱
				$sql ="SELECT * FROM `recipe` WHERE id IN(SELECT `recipe_id` FROM `ingredients` WHERE name LIKE '%{$recipe->ingredients}%') AND name LIKE '%{$recipe->name}%'";
			}else{
				//食材 + 食譜分類
				$sql ="SELECT * FROM `recipe` WHERE id IN(SELECT `recipe_id` FROM `ingredients` WHERE name LIKE '%{$recipe->ingredients}%') AND categories LIKE '%{$recipe->categories}%'";
			}
		}else if ($recipe->name!=""){
			$sql = "SELECT * FROM recipe WHERE name LIKE '%{$recipe->name}%'";
		}
		
		
		
		
		//$sql = "SELECT * FROM recipe WHERE name LIKE '%{$recipe->name}%' AND categories LIKE '%{$recipe->categories}%'";
		//$sql = "SELECT * FROM recipe WHERE name LIKE '%地瓜球%'";
		//echo $sql . '<br>';
		
		//if()){
			
			
		if ($result = $link->query($sql)) {
            if(mysqli_num_rows($result)==0){
				echo "0";
			}			
			//echo "共有 : {$result->num_rows}筆";
			while($row = $result->fetch_assoc()) {
                                echo json_encode($row).'<br><br>';
			        //echo $row['name'] . '<br>';
			}
		}
		//}
		$link->close();
	}
	
	
	
?>
