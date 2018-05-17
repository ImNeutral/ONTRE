<?php

//remember that this DS was not used in the image path method because web browsers act differently when it comes to Path directories. :)

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', 
	'C:'.DS.'xampp'.DS.'htdocs'.DS.'ONTRE'); 

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');


require_once(LIB_PATH.DS."config.php");

require_once(LIB_PATH.DS."functions.php");

require_once(LIB_PATH.DS."session.php");

require_once(LIB_PATH.DS."database_object.php");

require_once(LIB_PATH.DS."database.php");





 require_once(LIB_PATH.DS."pagination.php");
 
require_once(LIB_PATH.DS."librarian.php");

require_once(LIB_PATH.DS."thesis.php");

require_once(LIB_PATH.DS."adviser.php");

require_once(LIB_PATH.DS."author.php");

require_once(LIB_PATH.DS."category.php");

require_once(LIB_PATH.DS."college.php");

require_once(LIB_PATH.DS."department.php");
 
require_once(LIB_PATH.DS."keyword.php");
 
 
?>