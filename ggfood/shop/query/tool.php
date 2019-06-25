<?php
require_once('get_link.php');
function endMsg($code = 1,$msg = ""){
	$obj = new stdClass();
	$obj->msg = $msg;
	$obj->code = $code;
	return die(json_encode($obj));
}
/**
* @param colums : array 
* @return result : mysqli_result
*/
function query_randomOne($link,
                      $tableName,
                      $colums){
    $parsedColums = '';
    $d = '';
    foreach($colums as $col){
        $parsedColums .= 
            $link->escape_string($col) . $d;
        $d = ',';
    }
    $tableName = $link->escape_string($tableName);
    $sql = "SELECT $parsedColums 
        FROM '$tableName' AS t1 JOIN (
            SELECT ROUND(RAND() * (
                (SELECT MAX(id) FROM t1) - 
                (SELECT MIN(id) FROM t1)
            )+
            (SELECT MIN(id) FROM t1)) AS id) AS t2
        WHERE t1.id >= t2.id
        ORDER BY t1.id LIMIT 1";
    return $link->query($sql);
}
/**
* 建立一個物件，並將陣列中對應的欄位放入物件中
* @param Array          被比對的陣列
* @param Array<String>  陣列中需要比對的欄位
* 
* @return Object        轉換完的物件 or null
*/
function checkAndToObject(&$array){
    $num_args = func_num_args();
    $args= func_get_args();
	$obj = (object)[];
	
	for($i=1 ; $i<$num_args ; $i++){
		$field = $args[$i];
		if( isset($array[$field]) ){
			$obj->$field = $array[$field];
		}else{
			return null;
		}
	}
	return $obj;
}
/**
* 建立一個物件，並將陣列中對應的欄位放入物件中
* @param Array          被比對的陣列
* @param Array<String>  陣列中需要比對的欄位
* 
* @return Object        轉換完的物件 or null
*/
function nonCheckToObject(&$array){
    $num_args = func_num_args();
    $args= func_get_args();
	$obj = (object)[];
	
	for($i=1 ; $i<$num_args ; $i++){
		$field = $args[$i];
		if( isset($array[$field]) ){
			$obj->$field = $array[$field];
		}
	}
	return $obj;
}
function copyField($obj1,$obj2,$fields){
    foreach($fields as $key => $val){
        if(isset($obj2->$val))
            $obj1->$val = $obj2->$val;
        else
            return false;
    }
    return true;
}
function copyField2($obj1,$obj2,$fields,$useName){
    foreach($fields as $key => $val){
        if(isset($obj2->$val))
            $obj1->$useName[$key] = $obj2->$val;
        else
            return false;
    }
    return true;
}
?>