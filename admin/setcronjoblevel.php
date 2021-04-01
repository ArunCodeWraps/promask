<?php
include('../include/config.php');
include("../include/functions.php");
validate_admin();

//Set Level UP ON Month End 1 Date 
$currSql = $obj->query("select id from $tbl_cron_level where MONTH(cdate)=MONTH(now())");
$currRow = $obj->numRows($currSql);

if(empty($currRow)){

$selSql = $obj->query("select id from $tbl_user where status=1 and type='seller'",-1);
while($selResult = $obj->fetchNextObject($selSql)){
	$sellerId = $selResult->id;
	$totsell=0;
	$totalsell=0;
	$uSql = $obj->query("select id from $tbl_user where seller_id='$sellerId' and status=1 and type='user'",$debug=-1);// die;
	while($uResult = $obj->fetchNextObject($uSql)){
		$userId = $uResult->id;
		//Seller Users total Sell
		$totsell = $totsell + getTotalSalesLastMonth($userId);
	}
	//Seller Total Sale (Individual)
	$totalsell = $totsell  + getTotalSalesLastMonth($sellerId);

	$lSql = $obj->query("select level_name from $tbl_level where min_price <= '$totalsell' and max_price >= '$totalsell'",-1); //die;
	$lReslt = $obj->fetchNextObject($lSql);
	$level_name = $lReslt->level_name;
	if(!empty($level_name)){
		$obj->query("insert into $tbl_cron_level set user_id='$sellerId',level_name='$level_name',totsale='$totalsell',user_type='2'");
	}
}

}
$_SESSION['cron_sess_msg']="Your cron job is successfully updated";
header("location:welcome.php");
?>
