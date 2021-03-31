<?php
include('../include/config.php');
include("../include/functions.php");

$username=$_POST["username"];
$password=$_POST["password"];


$sql =$obj->query("select * from tbl_user where email='$username' and password='$password'",$debug=-1); //die;
$row=$obj->numRows($sql);

if($row>0){
    $line=$obj->fetchNextObject($sql);
    if ($line->status==1) {  
      $_SESSION['sess_user_id']=$line->id;
      $_SESSION['sess_username']=ucfirst($line->name);
      $_SESSION['sess_useremail']=$line->email;
      echo "1";
     } else {
      echo "0";
     }
  } else{
  echo "0";
  }

?>