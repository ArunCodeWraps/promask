<?php 
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();
$arr =$_POST['ids'];

$Submit =$_POST['buttonName'];
if(count($arr)>0){
	$str_rest_refs=implode(",",$arr);
	if($Submit=='Delete')
	{
	    $sql="delete from $tbl_level where id in ($str_rest_refs)"; 
		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
    }
	elseif($Submit=='Enable')
	{	
		$sql="update $tbl_level set status=1 where id in ($str_rest_refs)";
		$obj->query($sql);
		$sess_msg='Selected record(s) activated successfully';
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Disable')
	{		
		$sql="update $tbl_level set status=0 where id in ($str_rest_refs)";
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
	header("location: level-list.php");
	exit();
	
?>