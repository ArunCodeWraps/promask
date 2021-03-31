<?php
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
 //print_r($_REQUEST);
 $parent_id=$_REQUEST['parent_id'];
 $catArr=$obj->query("select barcode_number from $tbl_productprice where  status=1 and barcode_number like '%".trim($_REQUEST[q])."%'  order by id ",$debug=-1);
 if($obj->numRows($areaArr)){ 
 while($resultCat=$obj->fetchNextObject( $catArr)){
   $arr['key']=$resultCat->id;
   $arr['value']=$resultCat->barcode_number;
   $b[]=$arr;
   }}  
 echo json_encode($b);
   ?>


