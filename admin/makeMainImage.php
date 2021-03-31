<?php
	session_start(); 
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();
	
	if($_REQUEST['id']!='' && $_REQUEST['model_id']!=''){
	
	$obj->query("update $tbl_photo set main=0 where model_id='".$_REQUEST['model_id']."' ");	
	$obj->query("update $tbl_photo set main=".$_REQUEST['chk']." where id='".$_REQUEST['id']."' ");	
		
	}
	echo 1;
?>