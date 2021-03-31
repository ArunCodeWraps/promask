<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();

if($_REQUEST['id']!=''){
	$Sql = $obj->query("select id from $tbl_model where status=3",$debug=1);
	$Result = $obj->fetchNextObject($Sql);
	$obj->query("update $tbl_model set status=1,winner_date='0000-00-00',winner=0 where id='".$Result->id."'");
	$obj->query("update $tbl_model set winner=1,winner_date='".date('Y-m-d')."',status=3 where id='".$_REQUEST['id']."'",$debug=1); exit;
}
echo 1;
?>