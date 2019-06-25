<?php
session_start();
$postdata = file_get_contents("php://input",'r'); 
echo $postdata;
echo "==================<br>\r\n";
echo $_SERVER['QUERY_STRING'];
echo "==================<br>\r\n";
echo var_export($_POST);
echo "==================<br>\r\n";
echo var_export($_GET);
echo "==================<br>\r\n";
echo var_export($_SESSION);
?>