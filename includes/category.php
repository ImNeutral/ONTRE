<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Category extends DatabaseObject {

	protected static $table_name="category";
	protected static $db_fields = array('id', 'name', 'description' );
	public $id; 
	public $name;
	public $description;


	function __construct() {
		
	} 
  
	//common database methods

}  

$categories = Category::find_all();

?>  