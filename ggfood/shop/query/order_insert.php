<?php
	require_once('get_link.php');
	session_start();
	$msg = (object)[];
	$_SESSION["id"] = $_GET['id'];
	$_POST['m_id'] = $_GET['id'];
	$_POST['state'] = 0;
	
	if(isset($_SESSION['id'])){
		//檢查輸入欄位
		$checkField = ['address','payment_method','delivery_method','pid','quantity'];
		foreach($checkField as $field){
			if(!isset($_POST[$field])){
				$msg->code=3;
				$msg->msg="請重新確認表單是否填寫完畢!!";
				die(json_encode($msg));
			}
		}
		if(!isset($_POST['note'])) $_POST['note'] = '';
		//連接資料庫
		$link = get_link();
		//新增訂單

		$pid = $_POST['pid'];
		$q   = $_POST['quantity'];
		$pid_len = count($pid);
		$q_len   = count($q);
		if($pid_len == $q_len){
			$items = [];
			for($i=0;$i<$pid_len;$i+=1){
				$stmt = $link->prepare("SELECT price,quantity FROM products WHERE id = {$pid[$i]}");
				$stmt->execute();
				$stmt->bind_result($r_price,$r_quantity);
				$stmt->fetch();
				
				$item = (object)[];
				$item->price = $r_price;
				$item->quantity = $r_quantity;
				$items[] = $item;
				
				if($q[$i]>$r_quantity) {
					$msg->code=4;
					$msg->msg="庫存不足!!";
					$stmt->close();
					$link->close();
					die(json_encode($msg));
				}
			}
			$stmt->close();
			//INSERT INTO `orders`(`id`, `m_id`, `date`, `address`, `payment_method`, `delivery_method`, `state`, `note`) VALUES ()
			$date = date("Y-m-d");
			$stmt = $link->prepare("INSERT INTO orders(`m_id`, `date`, `address`, `payment_method`, `delivery_method`, `state`, `note`) VALUES(?,?,?,?,?,?,?)");
			$stmt->bind_param('issiiis',
				$_POST['m_id'],$date,
				$_POST['address'],$_POST['payment_method'],
				$_POST['delivery_method'],$_POST['state'],
				$_POST['note']);
			if( !$stmt->execute() ){
				$msg->code=9;
				$msg->msg = $stmt->error;
				die(json_encode($msg));
			}
				
			//插入item
			$oid = $stmt->insert_id;

			for($i=0;$i<$pid_len;$i+=1){
				$stmt = $link->prepare("INSERT INTO order_item VALUES(?,?,?,?)");
				$stmt->bind_param('iiii',$oid,$pid[$i],
					$items[$i]->price,$q[$i]);
				//$stmt->execute();
				if($stmt->execute()){
					$msg->code=0;
					$msg->msg="好的。訂單已送出";
                    
				}else{
					$msg->code=2;
					$msg->msg="訂購失敗，請稍後再試!!";
				}
			}
            if($msg->code==0){
                $sql="UPDATE `ggfood`.`notification` SET `notification` = notification+1 WHERE `notification`.`id` = 2";
                $stmt = $link->prepare($sql);
				$stmt->execute();
            }
		}else{
			$msg->code=3;
			$msg->msg="請重新確認表單是否填寫完畢!!";
		}
	}else{
		$msg->code=1;
		$msg->msg="請先登入??";
	}
	echo json_encode($msg);
?>