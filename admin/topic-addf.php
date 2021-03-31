<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
  $topic=mysql_real_escape_string($_POST['topic']);
  $description=mysql_real_escape_string($_POST['description']);
  $postedby=mysql_real_escape_string($_POST['postedby']);
  
  if($_REQUEST['submitForm']=='yes'){
	   $Image=new SimpleImage();
	   if($_FILES['photo']['size']>0 && $_FILES['photo']['error']=='' ){
	   $img=time().substr($_FILES['photo']['name'],-5);	   
	   move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_images/topic/".$img);	
	   copy("../upload_images/topic/".$img,"../upload_images/topic/thumb/".$img);
	   $Image->load("../upload_images/topic/thumb/".$img);   
	   $Image->resize(120,80);  
	   $Image->save("../upload_images/topic/thumb/".$img);  
	   }
  if($_REQUEST['id']==''){
	  $obj->query("insert into $tbl_topic set topic='$topic',photo='$img',postedby='$postedby',description='$description',posted_date=now(), status=1 ");
	  $_SESSION['sess_msg']='Article added sucessfully';  
	  }else{ 
	 
	   $sql="update $tbl_topic set topic='$topic',postedby='$postedby',description='$description' ";
	   if($img){
		$imgArr=$obj->query("select photo from $tbl_topic where id='".$_REQUEST['id']."'");	
		$resultImage=$obj->fetchNextObject($imgArr);
		@unlink("../upload_images/topic/".$resultImage->photo);
		@unlink("../upload_images/topic/thumb/".$resultImage->photo);
		$sql.=" ,photo='$img' ";
		}
	   $sql.=" where id='".$_REQUEST['id']."'";
	   $obj->query($sql);
	  $_SESSION['sess_msg']='Article updated sucessfully';   
        }
   header("location:topic-list.php");
   exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_topic where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SITE_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
function validate(obj)
{
if(obj.topic.value==''){
alert("Please enter title");
obj.topic.focus();
return false;
}
if(obj.description.value==''){
alert("Please enter description");
obj.description.focus();
return false;
}
}
</script>
<script type="text/javascript" src="../include/ckeditor/ckeditor.js"></script>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<?php include("header.php") ?>
<tr>
	<td align="right" class="paddRtLt70" valign="top">
		<table width="99%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			
				<td align="right" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="middle" class="headingbg bodr text14">
					<em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: Add Blog Article 
					<span  style="float:right; padding-right:10px;">
					<input type="button" name="add" value="View Blog Articles"  class="button" onclick="location.href='topic-list.php'" /></span></td>
						</tr>
						
						<tr>
							<td height="100" align="left" valign="top" bgcolor="#f3f4f6" class="bodr">
                            <form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
						<input type="hidden" name="submitForm" value="yes" />
						<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
							<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center" colspan="2" class="paddRt14 paddBot11">
										<font color="#FF0000"><strong><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';?></strong></font></td>
									</tr>
									<tr>
										<td width="18%" align="right" class="paddBot11 paddRt14">&nbsp;</td>
										<td width="82%" align="left" class="paddBot11"></td>
									</tr>
							
									<tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong>Title:</strong></td>
									  <td align="left" class="paddBot11"><input name="topic" type="text" id="topic" size="36" value="<?php echo stripslashes($result->topic);?>" /></td>
							  </tr>
                              <tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Image:</strong></td>
									  <td align="left" class="paddBot11"><input type="file" name="photo"  /><br/>
                                      <?php if(is_file("../upload_images/topic/thumb/".$result->photo)) {?>
                                      <img src="../upload_images/topic/thumb/<?php echo $result->photo ?>" />
                                      <?php } ?>
                                      
                                      </td>
							  </tr>
                              <tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong>Posted by :</strong></td>
									  <td align="left" class="paddBot11"><input name="postedby" type="text" id="postedby" size="36" value="<?php echo stripslashes($result->postedby);?>" /></td>
							  </tr>
                              
									 <tr>
                                      <td align="right" class="paddBot11 paddRt14"><strong> Details:</strong></td>
									  <td align="left" class="paddBot11"><textarea name="description"  class="ckeditor" id="description" rows="5" cols="40"><?php echo stripslashes($result->description); ?></textarea></td>
							  </tr>
									
								    <tr>
									   <td align="right" class="paddRt14 paddBot11">&nbsp;</td>
									   <td align="left" class="paddBot11">&nbsp;</td>
						      </tr>
								    <tr>
										<td width="18%" align="right" class="paddRt14 paddBot11">&nbsp;</td>
										<td width="82%" align="left" class="paddBot11">
											<input type="submit" name="submit" value="Submit"  class="submit" border="0"/> 	                  		 &nbsp;&nbsp;
											<input name="Reset" type="reset" id="Reset" value="Reset" class="submit" border="0" />									  </td>
									</tr>
								</table></form>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?php include('footer.php'); ?>
</table>
</body>
</html>


