<?php
session_start();
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();
 
// $mobile=$_POST['mobile'];
 extract($_POST);
 if (!empty($_POST)) {
 
// echo "<pre>";
//  print_r($_POST);

      $sql=$obj->query("insert into tbl_tmp_cart set product_id='$product_id',size_id='$size_id',qty='$qty',price='$price',cart_type='$cart_type'");
    
     if($sql){
            echo "1";
     }
     else{
            echo "0";
     }

 
 }


?>