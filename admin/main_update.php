<?php 
include('../include/config.php');
include("../include/functions.php");
        $id    = $_POST['id'];
		$main_val = $_POST['main_val'];
		$user_id = $_POST['user_id'];
		$sql1="update tbl_useraddress set main=0 where user_id=$user_id";
		$obj->query($sql1);
		$sql="update tbl_useraddress set main=1 where id=$id";
		$obj->query($sql);
		echo "1";
		//$sess_msg='Selected record(s) activated successfully';
		//$_SESSION['sess_msg']=$sess_msg;
	
	
?>
