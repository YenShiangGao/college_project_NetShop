<?php
session_start();
    $dbhost='localhost';
	$dbuser='root';
	$dbpassword='';
	$dbname='ggfood';
	$link =mysqli_connect($dbhost,$dbuser,$dbpassword) or die('error connection');
    $result = (object)[];
    $result->count = 0;
    mysqli_query($link,"set names 'utf8'");
	mysqli_select_db($link,$dbname);         
	if(isset($_SESSION['id'])){
        if(isset($_SESSION['authority'])){
            if($_SESSION['authority']==1){
                $sql="SELECT * FROM `notification` where `id` =".$_SESSION['id'];
                $db_result=mysqli_query($link, $sql);
                    $result->count = (int)mysqli_fetch_assoc($db_result)["notification"];
                    echo json_encode($result);
                
            }else{
                echo json_encode($result);
            }
        }
    }else{
        echo json_encode($result);
    }

    
    //範例結果
    /*
    黨名:notification.php
	{
        count : 0
    }
    */
?>