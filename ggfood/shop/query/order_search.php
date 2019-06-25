<?php
	require_once('get_link.php');
    //完成
	session_start();
	$msg=(object)[];
	if(isset($_GET['id'])){
		$login_id=$_GET['id'];
		$link = get_link();
		if($stmt = $link->prepare("SELECT id,m_id,date,address,payment_method,delivery_method,state,note FROM orders
		WHERE m_id = $login_id")){
			$stmt->execute();
			$stmt->bind_result($r_id,$r_m_id,$r_date,$r_address,$r_payment_method,$r_ship_method,$r_state,$r_note);
			$orders = [];
			while($stmt->fetch()){
				$order = (object)[];
				$order->id = $r_id;
                $order->m_id = $r_m_id;                    
				$order->date = $r_date;
				$order->address = $r_address;
				$order->payment_method = $r_payment_method;
				$order->ship_method = $r_ship_method;
				$order->state = $r_state;
				$order->note = $r_note;
				$orders[] = $order;
			}
			
			foreach($orders as $key => $order){
				$orders[$key]->items = [];
				//取得Item
				if($stmt = $link->prepare("SELECT pro_id,
					products.name as p_name,
					order_item.price as price,
					order_item.quantity as quantity,
					products.price as p_price ,
					products.quantity as p_quantity,
					products.uploader_id as p_uploader,
					products.description as p_description,
					products.date as p_date
					FROM order_item JOIN products
					ON pro_id = products.id WHERE order_id = {$order->id}")){
					$stmt->execute();
					$stmt->bind_result(
						$pro_id,
						$p_name,
						$price,
						$quantity,
						$p_price,
						$p_quantity,
						$p_uploader,
						$p_description,
						$p_date);
					while($stmt->fetch()){
						$item = (object)[];
						$item->p_id = $pro_id;
						$item->p_name = $p_name;
						$item->price = $price;
						$item->quantity = $quantity;
						$product = (object)[];
						$product->price = $p_price;
						$product->quantity = $p_quantity;
						$product->uploader = $p_uploader;
						$product->description = $p_description;
						$product->date = $p_date;
						
						$item->pro_info = $product;
						$orders[$key]->items[] = $item;
					}
				}
				
				$msg->code=0;
				$msg->msg="查詢完成";
				$msg->result= &$orders;
			}
		}else{
			$msg->code=2;
			$msg->msg="意外的錯誤!!";
		}	
	}else{
		$msg->code=1;
		$msg->msg="請先登入!!";
	}
	echo json_encode($msg);
?>