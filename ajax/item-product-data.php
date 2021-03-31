<?php
//session_start();
include('../include/config.php');
include("../include/functions.php");

//echo $_POST["itemId"];

if(!empty($_POST["itemId"])) {
  
  $sql1=$obj->query("SELECT pr.id,pr.product_id,pr.size,pr.price,pr.discount,pr.photo,u.name  FROM tbl_product_prices pr join tbl_unit as u on pr.unit_id=u.id WHERE pr.id='".$_POST['itemId']."'",$debug=-1);

  $row=$obj->fetchNextObject($sql1);

  
  echo json_encode($row);

  }




?>