<?php
	require_once('get_link.php');
    //完成
	session_start();
	$msg=(object)[];
	$link = get_link();
	if(isset($_POST['name'])){
		$name = $_POST['name'];
        //$sql="SELECT id,name,quantity,description,price,uploader_id,date,unit FROM products WHERE id IN(SELECT id FROM products WHERE name LIKE '%牛肉' OR name LIKE '%紅蘿蔔')"
        $sql="SELECT id,name,quantity,description,price,uploader_id,date,unit FROM products WHERE id IN(SELECT id FROM products WHERE $name)";
        //$sql="SELECT id,name,quantity,description,price,uploader_id,date,unit FROM products WHERE id IN(SELECT id FROM products WHERE name LIKE '%牛肉' OR name LIKE '%牛番茄' OR name LIKE '%洋蔥' OR name LIKE '%西洋芹' OR name LIKE '%蒜頭' OR name LIKE '%紅蘿蔔' OR name LIKE '%紅酒' OR name LIKE '%高筋麵粉' OR name LIKE '%月桂葉' OR name LIKE '%番茄醬' OR name LIKE '%義式香料' OR name LIKE '%鹽胡椒')";
		if($stmt = $link->prepare($sql)){
			$stmt->execute();
			
			$results = [];
			$stmt->bind_result($r_id,$r_name,$r_quantity,$r_description,
							  $r_price,$r_uploader_id,$r_date,$r_unit);
			while($stmt->fetch()){
				$product = (object)[];
				$product->id = $r_id;
				$product->name = $r_name;
				$product->quantity = $r_quantity;
				$product->description = $r_description;
				$product->uploader_id = $r_uploader_id;
				$product->date = $r_date;
				$product->price = $r_price;
                $product->unit = $r_unit;
				$results[] = $product;
			}
			$msg->code=0;
			$msg->msg="查詢成功!!";
			$msg->results = $results;
		}else{
			$msg->code=2;
			$msg->msg="意外的錯誤!!".$name;
		}
	}else{
	}
	echo json_encode($msg);
?>