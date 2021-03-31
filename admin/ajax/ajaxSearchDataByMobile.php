<?php
session_start();
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();
 
 $mobile=$_POST['mobile'];
 if ($_POST['mobile']) {
 	$data='';	
      $sql=$obj->query("SELECT * from tbl_user where mobile='$mobile' ");
      $result=$obj->fetchNextObject($sql);

      $data['mobile']=$result->mobile;
      $data['title']=$result->title;
      $data['name']=$result->name;
      $data['surname']=$result->surname;
      
     
      $seladd=$obj->query("SELECT * from tbl_useraddress where user_id=".$result->id);
      $add=$obj->fetchNextObject($add);
      
      // $selcity=$obj->query("SELECT * from tbl_city where id=".$add->city);
      // $city=$obj->fetchNextObject($selcity);

      //  $selarea=$obj->query("SELECT * from tbl_city where id='".$add->area."' AND city_id='".$add->city."' " );
      //  $area=$obj->fetchNextObject($selarea);

      $data['flat']=$add->flat;
      $data['flor']=$add->flor;
      $data['house_no']=$add->house_no;
      $data['street_no']=$add->street_no;
      $data['block']=$add->block;
      $data['sectorno']=$add->sectorno;
      $data['landmark']=$add->landmark;
      $data['city']=$add->city;
      $data['area']=$add->area;
      $data['state']=$add->state;
      //$data['other']=$add->other;
      echo json_encode($data);	

 
 }


?>