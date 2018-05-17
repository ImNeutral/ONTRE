<?php require_once("../../includes/initialize.php"); ?>


<?php 
//echo unlink('C:\xampp\htdocs\ONTRE\public\pdf\biodiversity') ? true : false;  

$var="<b>Peter Griffin<b>,./[]\1234567OIUYTRESDF:>";

echo (filter_var($var, FILTER_SANITIZE_STRING));
 




?> 