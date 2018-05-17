<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class College extends DatabaseObject {

	protected static $table_name="college";
	protected static $db_fields = array('id', 'name', 'abbreviation' );
	public $id; 
	public $name;
	public $abbreviation;


	function __construct() {
		
	} 
	
	//common database methods

}

if(isset($_SESSION['college_id'])){
	$college = College::find_by_id($_SESSION['college_id']);
}
?>  