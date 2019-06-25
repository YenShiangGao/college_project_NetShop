<?php
	require_once('get_link.php');
	require_once('tool.php');
	function fetchToObject($result){
		$orders = [];
		while($obj = $result->fetch_object()){
			$orderInfo = (object)[];
			$item = (object)[];
			copyField($orderInfo,$obj,
				['id','m_id','date','address','payment_method','delivery_method','state','note']);
			copyField2($item,$obj,
				['pid','i_price','i_quan','p_name','now_price','now_quantity','des'],
				['pid','price','quantity','name','n_price','n_quantity','description']);
			//查找是否有相同的訂單
			//如果有就將資料加到該筆訂單中
			if(isset($orderMap[$obj->id])){
				$orders[$orderMap[$obj->id]]->item[] = $item;
			}else{
				$orderMap[$obj->id] = count($orders);
				$orderInfo->item[] = $item;
				$orders[] = $orderInfo;
			}
		}
		return $orders;
	}
	function userFunc($id,$link){
		//查詢被訂購的產品
		$product = [];
		$msg = (object)[];
		$msg->code = 0;
		$msg->msg = '查詢成功';
		$sql = 'SELECT * FROM orders JOIN 
					(SELECT I.order_id as oid,I.pro_id as pid,I.price as i_price,I.quantity as i_quan,
					 P.name as p_name ,P.price as now_price ,P.quantity as now_quantity ,P.description as des 
					FROM (order_item as I JOIN products as P ON I.pro_id = P.id) 
					) as T ON orders.id = oid WHERE m_id = ?';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result){
			$msg->orders = fetchToObject($result);
			$result->free();
			$link->close();
			return $msg;
		}else{
			$link->close();
			endMsg(3,'未知的錯誤');
		}
	}
	function supplierFunc($id,$link){
		//查詢被訂購的產品
		$product = [];
		$msg = (object)[];
		$msg->code = 0;
		$msg->msg = '查詢成功';
		$sql = 'SELECT * FROM orders JOIN 
					(SELECT I.order_id as oid,I.pro_id as pid,I.price as i_price,I.quantity as i_quan,
					 P.name as p_name ,P.price as now_price ,P.quantity as now_quantity ,P.description as des 
					FROM (order_item as I JOIN products as P ON I.pro_id = P.id) 
					WHERE P.uploader_id = ?) as T ON T.oid=id';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result){
			$msg->orders = fetchToObject($result);
			$result->free();
			$link->close();
			return $msg;
		}else{
			$link->close();
			endMsg(3,'未知的錯誤');
		}
	}
	function adminFunc($id,$link){
		//查詢被訂購的產品
		$product = [];
		$msg = (object)[];
		$msg->code = 0;
		$msg->msg = '查詢成功';
		$sql = 'SELECT * FROM orders JOIN 
					(SELECT I.order_id as oid,I.pro_id as pid,I.price as i_price,I.quantity as i_quan,
						P.name as p_name ,P.price as now_price ,P.quantity as now_quantity ,P.description as des 
					FROM (order_item as I JOIN products as P ON I.pro_id = P.id)
					) as T ON T.oid=id';
		$stmt = $link->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result){
			$msg->orders = fetchToObject($result);
			$result->free();
			$link->close();
			return $msg;
		}else{
			$link->close();
			endMsg(3,'未知的錯誤');
		}
	}
	session_start();
	if(isset($_SESSION['id'])){
		$m_id = $_SESSION['id'];
		$m_authority = $_SESSION['authority'];
		$link = get_link();
		if($m_authority == 1){//當前登入者為供應商
			echo json_encode(supplierFunc($m_id,$link));
		}else if($m_authority == 0){
			echo json_encode(adminFunc($m_id,$link));
		}else{
			echo json_encode(userFunc($m_id,$link));
		}
	}else{
		endMsg(1,'請先登入');
	}
?>