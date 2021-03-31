<?php 
include('../include/config.php');
include("../include/functions.php");
        $area   = $_REQUEST['area'];
		$sql=$obj->query("select * from  $tbl_area where id=$area",$debug=-1);
        while($line=$obj->fetchNextObject($sql)){
		echo trim($line->pincode);
		}
?>
		

