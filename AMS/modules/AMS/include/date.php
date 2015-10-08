<?php
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function convert_date($date)  
{
	if (strpos(_SHORTDATESTRING, "/")) 
	{
	$date=str_replace("/", "-", $date);
	}
	return strtotime($date);
}
?>
