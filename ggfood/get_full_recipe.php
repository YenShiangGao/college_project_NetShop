<?php

	header('Content-Type: application/json');
	$id= $_GET['recipe'];

	$link=mysqli_connect("localhost","root","");
	mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,"ggfood");
	$id = $link->real_escape_string($id);
	$sql_1 = "SELECT * FROM recipe WHERE id=$id";
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
	
?>
