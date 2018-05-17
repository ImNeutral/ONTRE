<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Librarian extends DatabaseObject {

	protected static $table_name="librarian";
	protected static $db_fields = array('college_id', 'username', 'password' );
	public $college_id; 
	public $username;
	public $password;


	function __construct() {
		
	}
 
	public static function authenticate($username = "", $password = "") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		$sql = "SELECT * FROM librarian ";
		$sql .= "WHERE username ='{$username}' ";
		$sql .=  "AND password = '{$password}' ";
		$sql .= "LIMIT 1 ";

		$result_array = self::find_by_sql( $sql );
		return !empty($result_array) ? array_shift($result_array) : false;
	}
  
	//common database methods

}

if(isset($_SESSION['college_id'])){ 
	$sql = "SELECT * FROM librarian ";
	$sql .= "WHERE college_id=" . $database->escape_value($_SESSION['college_id']);
	$librarian = array_shift(Librarian::find_by_sql($sql));
}
?>  