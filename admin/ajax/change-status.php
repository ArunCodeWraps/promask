<?php
// session_start();
include("../../include/config.php");
include("../../include/functions.php"); 
validate_admin();
  

$id=$_POST['id'];
$tableName=$_POST['tableName'];  
$status=$_POST['status'];  

 if ($_POST['id']) {

     $sql=" update $tableName set status='$status'";
     $sql.=" where id='".$id."'";
     $obj->query($sql,$debug=-1);
 }


?>