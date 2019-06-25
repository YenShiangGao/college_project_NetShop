<?php
//完成
	require_once('get_link.php');
	session_start();
	$msg=(object)[];
	if(isset($_SESSION['id'])){
		if($_SESSION['authority']<2){//一般使用者不可新增
			//檢查輸入欄位
			if(!isset($_POST['name'])||!isset($_POST['price'])||
				!isset($_POST['description'])||!isset($_POST['quantity'])){
				$msg->code=3;
				$msg->msg="請重新確認表單是否填寫完畢!!";
			}else{
				$date = date("Y-m-d");
				//連接資料庫
				$link = get_link();
				//新增產品
				$sql="INSERT INTO products VALUES(?,?,?,?,?,?,?)";
				if($stmt = $link->prepare($sql)){
					$null = null;
					$stmt->bind_param('sisiiss',$null,$_SESSION['id'],$_POST['name'],$_POST['price'],
							$_POST['quantity'], $date,  $_POST['description']);
					if($stmt->execute()){
						$msg->code=0;
						$msg->msg="產品已新增完畢!!";
					}else{
						$msg->code=2;
						$msg->msg="產品新增失敗，請稍後再試!!";
					}
					$stmt->close();
				}else{
					echo htmlspecialchars($stmt->error);
				}
				$link->close();
			}
		}else{			
			$msg->code=4;
			$msg->msg="權限錯誤!!";
		}
	}else{
		$msg->code=1;
		$msg->msg="請先登入!!";
	}
	echo json_encode($msg);
?>