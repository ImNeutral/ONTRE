<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Department extends DatabaseObject {

	protected static $table_name="department";
	protected static $db_fields = array('id', 'name', 'college_id', 'abbreviation' );
	public $id; 
	public $college_id;
	public $name;
	public $abbreviation;


	function __construct() {
		
	}   
	
	public static function by_college_id(){
		global $database;
		if(isset($_SESSION['college_id'])){
			$sql = "SELECT * FROM department WHERE college_id=" . $database->escape_value($_SESSION['college_id']);
			$departments = Department::find_by_sql($sql);
			return $departments;
		}		
	} 
	//common database methods

}


$departments = Department::by_college_id();

		
?>  