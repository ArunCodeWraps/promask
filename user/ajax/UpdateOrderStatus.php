<?php
include("../../include/config.php");
include("../../include/functions.php"); 
validate_user();


$order_id=$_REQUEST['order_id'];
$status=$_REQUEST['status'];
if(!empty($order_id) && !empty($status)){
	$obj->query("update $tbl_order set order_status='$status' where id='$order_id' ",$debug=-1); //die;
}