<?php

//require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

class Keyword extends DatabaseObject {

	protected static $table_name="keyword";
	protected static $db_fields = array('id', 'keyword');
	public $id; 
	public $keyword; 


	function __construct() {
		
	} 
  
	//common database methods

}  

$keywords = Keyword::find_all();

?>  