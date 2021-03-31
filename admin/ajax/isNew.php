<?php
	include("../../include/config.php");
	include("../../include/functions.php"); 
	validate_admin();
	


	if($_REQUEST['pro_id']!=''){
		
	$obj->query("update tbl_product set is_new=".$_REQUEST['chk']." where id='".$_REQUEST['pro_id']."' ",$debug=-1);	
		
	}
	
	
	

	echo 1;
?>