<?php
	session_start(); 
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();
	
	if($_REQUEST['id']!=''){
		
		//echo "update $tbl_product set monthly_special=".$_REQUEST['chk']." where id='".$_REQUEST['id']."'";die;
	$obj->query("update $tbl_product set monthly_special=".$_REQUEST['chk']." where id='".$_REQUEST['id']."' ");	
		
	}
	echo 1;
?>