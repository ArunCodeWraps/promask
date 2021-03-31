<?php session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("notification.php");
validate_admin();
$arr =$_POST['ids'];
//print_r($_REQUEST);

$Submit =$_POST['what'];

if(count($arr)>0){
		$str_rest_refs=implode(",",$arr);
		if($Submit=='Delete')
		{
			
			/*$imageArr=$obj->query("select photo from  tbl_student where id in ($str_rest_refs) ");
			while($resultImage=$obj->fetchNextObject($imageArr)){
			@unlink("../upload_images/student/".$resultImage->photo); 
			}*/
		    $sql="delete from tbl_student_detail where id in ($str_rest_refs)"; 
			$obj->query($sql);
			$sess_msg='Selected record(s) deleted successfully';
			$_SESSION['sess_msg']=$sess_msg;
	    }
		elseif($Submit=='Enable')
		{	
			$sql="update tbl_student set status=1 where id in ($str_rest_refs)";
			$obj->query($sql);
			$sess_msg='Selected record(s) activated successfully';
			$_SESSION['sess_msg']=$sess_msg;
		}
		elseif($Submit=='Disable')
		{		
			 $sql="update tbl_student set status=0 where id in ($str_rest_refs)";
			$obj->query($sql);
			$sess_msg='Selected record(s) deactivated successfully';
			$_SESSION['sess_msg']=$sess_msg;
		}
		
	}
	
else{
	$sess_msg="Please select check box";
	$_SESSION['sess_msg']=$sess_msg;
	header("location: ".$_SERVER['HTTP_REFERER']);
	exit();
	}
	$sid= $_SESSION['sid'];
	header("location: student-semister-list.php?sid=".$sid);
	exit();
	
?>
