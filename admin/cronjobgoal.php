<?php
include('../include/config.php');
include("../include/functions.php");
validate_admin();

//Set Level UP ON Month End 1 Date 
$currSql = $obj->query("select id from $tbl_cron_goal where DAY(cdate)=DAY(now())",-1); //die;
$currRow = $obj->numRows($currSql);

if(empty($currRow)){

$totalunit=0;
$totalsell=0;
$selSql = $obj->query("select id from $tbl_user where status=1 and type='seller'",-1);
while($selResult = $obj->fetchNextObject($selSql)){
	$sellerId = $selResult->id;
	//1,5,7
	$totalunit = getTotalUnitLastDay($sellerId); //die;
	$totalsell = getTotalSaleLastDay($sellerId);

	$obj->query("insert into $tbl_cron_goal set user_id='$sellerId',totunit='$totalunit',totsale='$totalsell',user_type='2'");
}

}
$_SESSION['cron_sess_msg']="Your cron job is successfully updated";
//header("location:welcome.php");
?>
