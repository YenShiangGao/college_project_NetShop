<?php
	$dbhost='localhost';
	$dbuser='root';
	$dbpassword='';
	$dbname='ggfood';
	$link =mysqli_connect($dbhost,$dbuser,$dbpassword) or die('error connection');
	mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,$dbname);
	echo mysqli_error($link);
	$sql="SELECT COUNT(*) FROM recipe";
	$result=mysqli_query($link, $sql);
	
	header('Content-Type: application/json');
	
	if($result != false){	
		$count=mysqli_fetch_assoc($result);
        /*
		$id=rand(0,$count["COUNT(*)"]);
        */
        $file_times = (int)file_get_contents('times.txt');
        file_put_contents('times.txt',$file_times+1);
        $RRRRR = array('10160','273','5782');
        $id = $RRRRR[$file_times%3];
		$sql_1 = "SELECT * FROM recipe WHERE id >= $id LIMIT 1";
		$sql_2 = "SELECT step,text,img FROM `steps` WHERE `recipe_id` = $id ORDER BY `steps`.`step` ASC";
		$sql_3 = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = $id ORDER BY `ingredients`.`id` ASC";
		$result_recipe=mysqli_query($link,$sql_1);
		$result_steps=mysqli_query($link,$sql_2);
		$result_ingredients=mysqli_query($link,$sql_3);
		
		$recipe=mysqli_fetch_object($result_recipe);
		
		//foreach($result_steps as )
		
		//echo json_encode($recipe)."<br>";
		
		//echo json_encode
		$i = 0;
		foreach($result_steps as $value){
			$step = new stdClass();
			
			foreach($value as $key=>$value){
				$step->$key = $value;
				//echo $key." : ".$value."<br>";
			}
			$recipe->steps[$i] = $step;
			$i+=1;
		}
		$i = 0;
		foreach($result_ingredients as $value){
			$ingredient = new stdClass();
			
			foreach($value as $key=>$value){
				$ingredient->$key = $value;
				//echo $key." : ".$value."<br>";
			}
			$recipe->ingredients[$i] = $ingredient;
			$i+=1;
		}
		echo json_encode($recipe);
	}else{
		echo mysqli_error($link);
	}
	
?>