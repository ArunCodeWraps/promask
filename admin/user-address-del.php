<?php session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();

$user_id = $_REQUEST['user_id'];

$Submit =$_POST['what'];

if(count($_REQUEST['ids'])>0){
	$str_rest_refs =implode(",",$_REQUEST['ids']);
	if($Submit=='Delete')
	{	  
	   
	   $sql="delete from $tbl_useraddress where id in ($str_rest_refs)";
		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
    }
	elseif($Submit=='Enable')
	{	
		$sql="update $tbl_useraddress set status=1 where id in ($str_rest_refs)";
		$obj->query($sql);
		$sess_msg='Selected record(s) activated successfully';
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Disable')
	{		
		 $sql="update $tbl_useraddress set status=0 where id in ($str_rest_refs)";
		$obj->query($sql);
		$sess_msg='Selected record(s) deactivated successfully';
		$_SESSION['sess_msg']=$sess_msg;
	}
	
}
	
else{
	$sess_msg="Please select check box";
	$_SESSION['sess_msg']=$sess_msg;
	header("location: ".$_SERVER['HTTP_REFERER']);
	exit();
	}
	header("location: useraddress-list.php?id=$user_id");
	exit();
	
?>
