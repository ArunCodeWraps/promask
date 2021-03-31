 <?php
include("../../include/config.php");
include("../../include/functions.php"); 

 


 if(!empty($_POST["key_id"])) {
   	 $id = $_POST["key_id"];
	 $obj->query("delete from tbl_user_key where id='".$id."'",$debug=-1);
	 echo "1";
  }




  ?>