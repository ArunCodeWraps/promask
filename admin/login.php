<?php

include("../include/config.php");
include("../include/functions.php");
$username=$obj->escapestring($_POST['username']);
$password=$obj->escapestring($_POST['password']);


if($_POST['logged'] == "yes"){
	$sql =$obj->query("select * from $tbl_admin where username='$username' and password='$password' and status='1' ",$debug=-1); 
	$row=$obj->numRows($sql);
	if($row>0){
		$line=$obj->fetchNextObject($sql);
		$_SESSION['sess_admin_id']=$line->id;
		$_SESSION['sess_admin_username']=$line->username;
		$_SESSION['sess_admin_empname']=$line->emp_name;
		$_SESSION['user_type']=$line->user_type;

		if($line->user_type=='admin'){
			header("location: welcome-emp.php");
		}else{
			header("location: welcome.php");
		}   	
	} else{
	
	$_SESSION['sess_msg'] = 'Invalid Username/Password';
	header("Location: index.php");
  }
}
?>