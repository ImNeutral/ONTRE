
<?php  require_once('../includes/initialize.php');  ?>
<?php
$theses_search = Thesis::search_thesis('a'); 
		   

$thesis = array();
$count_all=0;
foreach($theses_search as $thes){
	$count_all++;

	$thesis[] = $thes; 
} 
  
  
print_r($thesis);

?>