<?php
//session_start();
include('../include/config.php');
include("../include/functions.php");

$newsemail=$_POST["subscribe_email"];

$sql =$obj->query("select * from tbl_newsletter where email='$newsemail'",$debug=-1);
$row=$obj->numRows($sql);

if($row>0){

  echo '0';

}else {
  
  $sql=$obj->query("insert into tbl_newsletter set email='$newsemail'",$debug=-1);
  echo '1';

}
     


  

?>