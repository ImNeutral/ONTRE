<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Adviser extends DatabaseObject {

	protected static $table_name="adviser";
	protected static $db_fields = array('id', 'fullname', 'dept_id' );
	public $id; 
	public $fullname;
	public $dept_id;


	function __construct() {
		
	}
	
	public static function exists($fullname = "", $dept_id = 0) {
		global $database;
		$fullname = $database->escape_value($fullname);
		$dept_id = $database->escape_value($dept_id);

		$sql = "SELECT * FROM adviser ";
		$sql .= "WHERE fullname ='{$fullname}' ";
		$sql .=  "AND dept_id = '{$dept_id}' ";
		$sql .= "LIMIT 1 ";

		$result_array = self::find_by_sql( $sql );
		return !empty($result_array) ? true : false;
	}
  
	//common database methods

}  
if(isset($_SESSION['college_id'])){
	//SELECT ad.id, ad.fullname, ad.dept_id 
	//	FROM adviser ad inner join department dept 
	//		on ad.dept_id=dept.id WHERE dept.college_id=5001
	$sql = "SELECT ad.id, ad.fullname, ad.dept_id FROM adviser ad ";
	$sql .= "inner join department dept on ad.dept_id=dept.id ";
	$sql .= "WHERE dept.college_id=" . $database->escape_value($_SESSION['college_id']);
	$sql .= " ORDER BY ad.fullname ASC";
	$advisers = Adviser::find_by_sql($sql); 
}
?>  