<?php

class DB {

	function conexion(){
		$conexion = mysql_connect(SQL_HOST,SQL_USER,SQL_PASS);
		mysql_select_db(SQL_DB, $conexion);
		return $conexion;
	}
	
	function result($sql){
		$arr = array();
		$conexion = $this->conexion();
		$result = mysql_query($sql, $conexion);
		while($row = mysql_fetch_array($result)){
			$arr[] = $row;
		}
		return $arr;
	}
	
	function insert($insert){
		$conexion = $this->conexion();
		mysql_query($insert, $conexion);
		return mysql_insert_id();
	}
	
	function row($sql){
		$arr = array();
		$conexion = $this->conexion();
		$result = mysql_query($sql, $conexion);
		while($row = mysql_fetch_array($result)){
			$arr[] = $row;
			break;
		}
		if(count($arr) > 0){
			return $arr;
		}else{
			return NULL;
		}
	}
	
	function update($update){
		$conexion = $this->conexion();
		//mysql_query($update, $conexion);
                if (mysql_query($update, $conexion)) {
                    return "Record updated successfully";
                } else {
                    return "Error updating record: " . mysqli_error($conn);
                }
	}
	
	function execute($delete){
		$conexion = $this->conexion();
		mysql_query($delete, $conexion);
	}
	
}
$DB = new DB;

?>