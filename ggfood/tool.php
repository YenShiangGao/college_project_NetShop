<?php
function endMsg($code = 1,$msg = ""){
	$obj = new stdClass();
	$obj->msg = $msg;
	$obj->code = $code;
	return die(json_encode($obj));
}
/**
* @param colums : array 
* @param limit : int 資料筆數
* @return result : mysqli_result
*/
function query_random($link,
                      $tableName,
                      $colums,
                      $limit = 1){
    $parsedColums = '';
    $d = '';
    foreach($colums as $col){
        $parsedColums .= 
            $link->escape_string($col) . $d;
        $d = ',';
    }
    $tableName = $link->escape_string($tableName);
    $limit = $link->escape_string($limit);
    $sql = "SELECT $parsedColums 
        FROM '$tableName' AS t1 JOIN (
            SELECT ROUND(RAND() * (
                (SELECT MAX(id) FROM t1) - 
                (SELECT MIN(id) FROM t1)
            )+
            (SELECT MIN(id) FROM t1)) AS id) AS t2
        WHERE t1.id >= t2.id
        ORDER BY t1.id LIMIT $limit";
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

?>