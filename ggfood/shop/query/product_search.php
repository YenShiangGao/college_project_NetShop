<?php
	require_once('get_link.php');
    //完成
	session_start();
	$msg=(object)[];
	$link = get_link();
	if(isset($_POST['name'])){
		$name = '%'.$_POST['name'].'%';
		
		if($stmt = $link->prepare('SELECT id,name,quantity,description,price,uploader_id,date,unit FROM products WHERE enable = 1 AND name LIKE ? LIMIT 1')){
			$stmt->bind_param("s",$name);
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
			$msg->msg="意外的錯誤!!";
		}
	}else{
	}
	echo json_encode($msg);
?>