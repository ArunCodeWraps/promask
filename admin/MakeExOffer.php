<?php
	session_start(); 
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();
	
	if($_REQUEST['id']!=''){
		
	$obj->query("update $tbl_product set ex_offer_zone=".$_REQUEST['chk']." where id='".$_REQUEST['id']."' ");	
		
	}
	echo 1;
?>