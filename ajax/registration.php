<?php
include('../include/config.php');
include("../include/functions.php");

$user_name=$_POST["user_name"];
$user_email=$_POST["user_email"];
$user_password=$_POST["user_password"];


$sql =$obj->query("select * from tbl_user where email='$user_email'",$debug=-1);
$row=$obj->numRows($sql);

if($row<=0){
    

     $obj->query("insert into tbl_user set 
                name='$user_name',
                email='$user_email',
                password='$user_password',
                type='user',
                status='1'
                ",-1);

      echo '1';
     
  } else{
  
    echo "0";
  
  }

?>