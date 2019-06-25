<?php
	require_once('get_link.php');
    //完成
	session_start();
	$msg=(object)[];
//	if(isset($_SESSION['id'])){
    $link = get_link();
//		if(isset($_POST['name'])){
            //var tds = [obj.id,obj.name,obj.description,obj.price,obj.quantity,obj.uploder_id,obj.date];
    if($stmt = $link->prepare('SELECT id,name,quantity,description,price,uploader_id,date FROM products WHERE enable = 1;')){
        $stmt->execute();

        $results = [];
        $stmt->bind_result($r_id,$r_name,$r_quantity,$r_description,
                          $r_price,$r_uploader_id,$r_date);
        while($stmt->fetch()){
            $product = (object)[];
            $product->id = $r_id;
            $product->name = $r_name;
            $product->quantity = $r_quantity;
            $product->description = $r_description;
            $product->uploader_id = $r_uploader_id;
            $product->date = $r_date;
            $product->price = $r_price;

            $results[] = $product;
        }
        $msg->code=0;
        $msg->msg="查詢成功!!";
        $msg->results = &$results;
    }else{
        $msg->code=2;
        $msg->msg="意外的錯誤!!";
    }
//		}else{
//		}
//	}else{
//		$msg->code=1;
//		$msg->msg="請先登入!!";
//	}
	echo json_encode($msg);
?>