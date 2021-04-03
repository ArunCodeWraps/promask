<?php
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();


$order_id=$_REQUEST['order_id'];
$status=$_REQUEST['status'];
if(!empty($order_id) && !empty($status)){
	$whr="";
	if($status==1){
		$whr = ",payment_status=0";
	}else if($status==2){
		$whr = ",payment_status=0";
	}else if($status==3){
		$whr = ",payment_status=1";
	}else if($status==4){
		$whr = ",payment_status=0";
	}
	$obj->query("update $tbl_order set order_status='$status' $whr where id='$order_id' ",$debug=-1); //die;
}