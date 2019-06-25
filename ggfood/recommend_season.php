<?php
	
	$dbhost='localhost';
	$dbuser='root';
	$dbpassword='';
	$dbname='ggfood';
	$link =mysqli_connect($dbhost,$dbuser,$dbpassword) or die('error connection');
	mysqli_query($link,"SET CHARACTER SET 'UTF8'");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET CHARACTER_SET_CLIENT=UTF8");
	mysqli_query($link,"SET CHARACTER_SET_RESULTS=UTF8");
	mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,$dbname);
	echo mysqli_error($link);


	$sql="SELECT COUNT(*) FROM recipe";
	$result=mysqli_query($link, $sql);
	//$season = $_POST["season"];
	$season="";
	$date = (int)date('m');
	if($date>=2&&$date<=4){
		$season="spring";
	}else if($date>=5&&$date<=7){
		$season="summer";
	}else if($date>=8&&$date<=10){
		$season="fall";
	}else if($date==11||$date==12||$date==1){
		$season="winter";
	}
	//header('Content-Type: application/json');
	
	if($result != false){	
		$count=mysqli_fetch_assoc($result);
		$id=mt_rand(0,$count["COUNT(*)"]);
		$probability = mt_rand(0,100);
		if($probability > 40){
			//當季隨機推薦
			$sql_season = "SELECT food_name FROM 24_season WHERE season='$season' ORDER BY RAND() LIMIT 1";
			$result_name = mysqli_query($link,$sql_season);
			$name = $result_name->fetch_assoc();
			$sql_season_ingredients = "SELECT recipe_id FROM ingredients WHERE name='{$name['food_name']}' ORDER BY RAND() LIMIT 1";
			$result2 = mysqli_query($link,$sql_season_ingredients);
			$season_id = $result2->fetch_assoc();
			$sql_season_recipe = "SELECT * FROM recipe WHERE id='{$season_id['recipe_id']}'";
			//$sql_2 = "SELECT step,text FROM `steps` WHERE `recipe_id` = $id ORDER BY `steps`.`step` ASC";
			$sql_step = "SELECT step,text FROM `steps` WHERE `recipe_id` = '{$season_id['recipe_id']}' ORDER BY `steps`.`step` ASC";
			$sql_ingredients = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = '{$season_id['recipe_id']}' ORDER BY `ingredients`.`id` ASC";
			$result_season_recipe = mysqli_query($link,$sql_season_recipe);
			$result_season_steps = mysqli_query($link,$sql_step);
			$result_season_ingredients = mysqli_query($link,$sql_ingredients);
			$season_recipe = mysqli_fetch_object($result_season_recipe);

			$i = 0;
			foreach($result_season_steps as $value){
				$step = new stdClass();
				
				foreach($value as $key=>$value){
					$step->$key = $value;
					//echo $key." : ".$value."<br>";
				}
				$season_recipe->steps[$i] = $step;
				$i+=1;
			}
			$i = 0;
			foreach($result_season_ingredients as $value){
				$ingredient = new stdClass();
				
				foreach($value as $key=>$value){
					$ingredient->$key = $value;
					//echo $key." : ".$value."<br>";
				}
				$recipe->ingredients[$i] = $ingredient;
				$i+=1;
			}
			print(json_encode($season_recipe));
		}else{
			$sql_1 = "SELECT * FROM recipe WHERE id=$id";
			$sql_2 = "SELECT step,text FROM `steps` WHERE `recipe_id` = $id ORDER BY `steps`.`step` ASC";
			$sql_3 = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = $id ORDER BY `ingredients`.`id` ASC";
			$result_recipe=mysqli_query($link,$sql_1);
			$result_steps=mysqli_query($link,$sql_2);
			$result_ingredients=mysqli_query($link,$sql_3);
			$recipe=mysqli_fetch_object($result_recipe);

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
			print(json_encode($recipe));
		}
		
		//foreach($result_steps as )
		
		//echo json_encode($recipe)."<br>";
		
		//echo json_encode
		
	}else{
		echo mysqli_error($link);
	}
	
?>