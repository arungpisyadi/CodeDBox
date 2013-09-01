<?php
require_once ('config.php');

//define some element for MySQL class
define('DB_SERVER', $db_server);
define('DB_NAME',$db_name);
define('DB_USER', $db_user);
define('DB_PASS', $db_pass);

//start MySQL class
class mysqlClass{
	var $db, $conn;
	//construct server as object to connect
	public function __construct($server, $database, $username, $password){
		$this->conn = mysql_connect($server, $username, $password);
		$this->db = mysql_select_db($database, $this->conn);
	}
	
	//insert new data to MySQL
	public function insert_array($table, $insert_values){
		foreach($insert_values as $key=>$value){
			$keys[] = $key;
			$insertvalues[] = '\''.$value.'\'';
		}
		$keys = implode(',', $keys);
		$insertvalues = implode(',', $insertvalues);
		$sql = "INSERT INTO $table ($keys) VALUES ($insertvalues)";
		$this->sqlordie($sql);
	}
	
	//update data in MySQL
	public function update_array($table, $keyColumnName, $id, $update_values){
		foreach($update_values as $key=>$value){
			$sets[] = $key.'=\''.$value.'\'';
		}
		$sets = implode(',', $sets);
		$sql = "UPDATE $table SET $sets WHERE $keyColumnName = '$id'";
		$this->sqlordie($sql);
	}
	
	//get data from MySQL
	public function check_login($username, $password){
		$sql = "SELECT * FROM cdb_user WHERE user_name = '$username' AND user_pass = '$password'";
		$result = $this->sqlordie($sql);
		$login = mysql_num_rows($result);
		return $login;
	}
	
	public function get_data_by_ID($table, $keyColumnName, $id, $fields = "*"){
		$sql = "SELECT $fields FROM $table WHERE $keyColumnName = '$id'";
		$result = $this->sqlordie($sql);
		return mysql_fetch_array($result);
	}
	
	public function get_data_by_group($table, $groupKeyName, $groupID, $orderKeyName = '', $order = 'ASC', $fields = '*'){
		$orderSQL = '';
		if($orderKeyName != '') $orderSQL = "ORDER BY $orderKeyName $order";
		$sql = "SELECT $fields FROM $table $groupKeyName = '$groupID' ". $orderSQL;
		$result = $this->sqlordie($sql);
		while($row = mysql_fetch_assoc($result)){
			$records[] = $row;
		}
		return $records;
	}
	
	//main SQL Language
	private function sqlordie($sql){
		$return_result = mysql_query($sql, $this->conn);
		if($return_result){
			return $return_result;
		}else{
			$this->sql_error($sql);
		}
	}
	private function sql_error($sql){
		echo mysql_error($this->conn).' <br />';
		die('error: '.$sql);
	}

}//end MySQL class

?>