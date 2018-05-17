<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Author extends DatabaseObject {

	protected static $table_name="author";
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

		$sql = "SELECT * FROM author ";
		$sql .= "WHERE fullname ='{$fullname}' ";
		$sql .=  "AND dept_id = '{$dept_id}' ";
		$sql .= "LIMIT 1 ";

		$result_array = self::find_by_sql( $sql );
		return !empty($result_array) ? true : false;
	}
	
	public static function find_by_college_id($college_id){ 
		global $database;
		$sql = "SELECT ad.id, ad.fullname, ad.dept_id FROM author ad ";
		$sql .= "inner join department dept on ad.dept_id=dept.id ";
		$sql .= "WHERE dept.college_id=" . $database->escape_value($_SESSION['college_id']) ;
		$sql .= " ORDER BY ad.fullname ASC";
		return self::find_by_sql($sql); 
	}

	public static function is_duplicate($fullname="", $thesis_id=0){
		global $database;
		$fullname = $database->escape_value($fullname);
		$thesis_id = $database->escape_value($thesis_id);

		//SELECT * FROM author a INNER JOIN author_thesis ath ON a.id=ath.author_id WHERE a.fullname="rhodema sorronda" AND ath.thesis_id='2015019'
		$sql = "SELECT * FROM author a ";
		$sql .= "INNER JOIN author_thesis ath ON a.id=ath.author_id ";
		$sql .= "WHERE a.fullname ='{$fullname}' ";
		$sql .=  "AND ath.thesis_id = '{$thesis_id}' ";
		$sql .= "LIMIT 1 ";

		$result_array = self::find_by_sql( $sql );
		return !empty($result_array) ? true : false;
	}


	public static function author_exists($fullname = "", $dept_id = 0) {
		global $database;
		$fullname = $database->escape_value($fullname);
		$dept_id = $database->escape_value($dept_id);

		$sql = "SELECT * FROM author ";
		$sql .= "WHERE fullname ='{$fullname}' ";
		$sql .=  "AND dept_id = '{$dept_id}' ";
		$sql .= "LIMIT 1 ";

		$result_array = self::find_by_sql( $sql );
		return array_shift($result_array);
	}


	//common database methods

}  
if(isset($_SESSION['college_id'])){
	//SELECT ad.id, ad.fullname, ad.dept_id 
	//	FROM adviser ad inner join department dept 
	//		on ad.dept_id=dept.id WHERE dept.college_id=5001
	$authors = Author::find_by_college_id($_SESSION['college_id']);

}
?>  