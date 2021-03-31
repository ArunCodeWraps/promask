<?php
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
 //print_r($_REQUEST);
 $catArr=$obj->query("select * from $tbl_maincategory where  status=1 order by parent_id limit 0,20",$debug=-1);
 if($obj->numRows($areaArr)){ 
 while($resultCat=$obj->fetchNextObject( $catArr)){
   $arr['key']=$resultCat->id;
   $arr['value']=getCategoryTree($resultCat->id,$array='');
   $b[]=$arr;
   }}  
 echo json_encode($b);
   ?>


