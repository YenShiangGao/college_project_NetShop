<?php
	require_once('tool.php');

	$noInfo_flag = false;		//註冊資料沒寫完
	$duplicate_flag = false;	//重複註冊
	$sucess_flag = false;		//註冊成功
	$fail_flag = false;			//註冊失敗
	//$_POST=$_GET;
	
	//連接資料庫
	error_reporting(0);
	$link = mysqli_connect('localhost','root')or die('error connection');
	$link->select_db('ggfood');
	$link->query("set names UTF8");
	//點選送出後判斷是否有沒填寫資料
		if(empty($_POST["acc"])||empty($_POST["pas"])||empty($_POST["nick"])||empty($_POST["email"])||
		empty($_POST["sex"])||empty($_POST["address"])||empty($_POST["phone"])){
			endMsg(2,'表單填寫不完整');
			
			
		}else{
			$account=$_POST["acc"];
			$password=$_POST["pas"];
			$nick=$_POST["nick"];
			$email=$_POST["email"];
			$sex=$_POST["sex"];
			$address=$_POST["address"];
			$phone=$_POST["phone"];
			//檢查資料是否有帳號是否有重複
			$result = mysqli_query($link,"SELECT * FROM member WHERE account = '$account'");
			if($result){
				if(mysqli_num_rows($result) == 0){
					$sql = "INSERT INTO member(account, password, nick, email, sex, address, phone,authority)VALUES('$account','$password','$nick',
							'$email','$sex','$address','$phone','2')";
					if(mysqli_query($link,$sql)){
						endMsg(0,"註冊成功");
					}else{
						endMsg(3,"意外的錯誤");
					}
				}else{
					endMsg(1,'帳號已存在');
				}
			}
		}
?>