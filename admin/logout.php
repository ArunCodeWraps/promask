<?php
	include("../include/config.php");
	include("../include/functions.php");
	
	$_SESSION['sess_msg']='';
	$_SESSION['sess_admin_id']='';
	$_SESSION['username']='';
	$_SESSION['user_type']='';
	
	
session_destroy();
header("Location: index.php");

?>