<?php
	$dbhost='localhost';
	$dbuser='root';
	$dbpassword='';
	$dbname='ggfood';
	$link =mysqli_connect($dbhost,$dbuser,$dbpassword) or die('error connection');
	mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,$dbname);
	
	header('Content-Type: application/json');
    
	
	if(isset($_GET['specify'])){//如果有定義$_GET['specify']則改為指定分類推薦
		$result = getRecipeByCategory($link,$_GET['specify']);
		$result->method = 3;
		echo json_encode($result);
	}else{//隨機選擇一個推薦方式
		if(isset($_GET['d'])){//debug用   直接設定機率數值
			$num = (int)$_GET['d'];
		}else{
			//如果未傳遞偏好資訊則由getRecipeByRandom或getRecipeBySeason進行處理
			if(isset($_GET['categories'])){
				$num = mt_rand(1,100);
			}else{
				$num = mt_rand(1,60);
			}
		}
		if($num <= 20){
			$result = getRecipeByRandom($link);
			$result->method = 0;
		}else if($num <= 60){
			$result = getRecipeBySeason($link);
			$result->method = 1;
		}else{
			$result = getRecipeByCategory($link,$_GET['categories']);
			$result->method = 2;
			//$_GET['categories']偏好
		}
		echo json_encode($result);
	}
	
	
	function getRecipeByRandom($link){
        $sql="SELECT COUNT(*) as count FROM recipe";
        $result=mysqli_query($link, $sql);
        if($result){
            $count=(int)mysqli_fetch_assoc($result)["count"];
            $id=mt_rand(1,$count - 1);
            $sql_1 = "SELECT * FROM recipe WHERE id >= $id LIMIT 1";
            $result_recipe=mysqli_query($link,$sql_1);
            $recipe=mysqli_fetch_object($result_recipe);
            $real_id = $recipe->id;
            $sql_2 = "SELECT step,text FROM `steps` WHERE `recipe_id` = $real_id ORDER BY `steps`.`step` ASC";
            $sql_3 = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = $real_id ORDER BY `ingredients`.`id` ASC";
            $result_steps=mysqli_query($link,$sql_2);
            $result_ingredients=mysqli_query($link,$sql_3);
			//return mysqli_fetch_object($result_steps);
            return combineRecipe($recipe,$result_steps,$result_ingredients);
        }else{
            return mysqli_error($link);
        }
    }
    function getRecipeBySeason($link){
        $SEASON = ['spring','summer','fall','winter'];
        //查詢當季的所有食材
        $month = (int)date("m");
        $sql_s = "SELECT food_name FROM `24_season` WHERE season = '{$SEASON[$month/4]}'";
        $result_season = mysqli_query($link,$sql_s);
        //從所有食材中隨機挑選一個
        $food_name = getRandomRow($result_season)->food_name;
        //用食材去找食譜ID
        $sql_id = "SELECT recipe_id FROM `ingredients` WHERE name = '$food_name'";
        $result_id = mysqli_query($link,$sql_id);
        
        $id = getRandomRow($result_id)->recipe_id;

        $sql_1 = "SELECT * FROM recipe WHERE id = '$id' LIMIT 1";
        $sql_2 = "SELECT step,text FROM `steps` WHERE `recipe_id` = '$id' ORDER BY `steps`.`step` ASC";
        $sql_3 = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = '$id' ORDER BY `ingredients`.`id` ASC";
        $result_recipe=mysqli_query($link,$sql_1);
        $result_steps=mysqli_query($link,$sql_2);
        $result_ingredients=mysqli_query($link,$sql_3);

        $recipe=mysqli_fetch_object($result_recipe);
        
        return combineRecipe($recipe,$result_steps,$result_ingredients);
    }
    function getRecipeByCategory($link,$category){
		
        //$categories = $category;
		$categories = explode(',',$category);
		$categories_count = count($categories);
		$num = mt_rand(0,$categories_count-1);
		$sql = "SELECT * FROM `recipe` WHERE `categories` = '{$categories[$num]}'";
        $result = mysqli_query($link,$sql);
        $recipe = getRandomRow($result);
        $id = $recipe->id;
        $sql_2 = "SELECT step,text FROM `steps` WHERE `recipe_id` = '$id' ORDER BY `steps`.`step` ASC";
        $sql_3 = "SELECT name,weight FROM `ingredients` WHERE `recipe_id` = '$id' ORDER BY `ingredients`.`id` ASC";
        $result_steps=mysqli_query($link,$sql_2);
        $result_ingredients=mysqli_query($link,$sql_3);

        return combineRecipe($recipe,$result_steps,$result_ingredients);
    }
    function combineRecipeAndInfo(&$recipe ,&$result_steps ,&$result_ingredients,$debug){
        $result = combineRecipe($recipe ,$result_steps ,$result_ingredients);
        $result->debug = $debug;
        return $result;
    }
    function combineRecipe(&$recipe ,&$result_steps ,&$result_ingredients){
        $result = new stdClass();
        assignAttribute($result,$recipe);
        foreach($result_steps as $value){
            $step = new stdClass();
            assignAttribute($step,$value);
            $result->steps[] = $step;
        }
        foreach($result_ingredients as $value){
            $ingredient = new stdClass();
            assignAttribute($ingredient,$value);
            $result->ingredients[] = $ingredient;
        }
        return $result;
        
    }
    function assignAttribute(&$target ,&$source){
        foreach($source as $key=>$value){
            $target->$key = $value;
        }
    }
    function parseArray($arr){
        $count = count($arr);
        if($count > 0){
            $str = "'$arr[0]'";
            for($i=1;$i<$count;$i++){
                $str .= ",'{$arr[$i]}'";
            }
            return $str;
        }
        return '';
    }
    /**
     * 1個result只能用一次
    */
    function getRandomRow($mysqli_result){
        $num_rows = mysqli_num_rows($mysqli_result);
        $r = mt_rand(0,$num_rows-1);
        $i = 0;
        while ($obj = $mysqli_result->fetch_object()) {
            if($i == $r)
                break;
            $i+=1;
        }
        $mysqli_result->close();
        return $obj;
    }
?>