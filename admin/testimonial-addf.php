<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
  $testimonial=mysql_real_escape_string($_POST['testimonial']);
  $posted_by=mysql_real_escape_string($_POST['posted_by']);
  if($_REQUEST['submitForm']=='yes'){
	  if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
	  $Image=new SimpleImage();
	  $img=time().$_FILES['photo']['name'];
	  move_uploaded_file($_FILES['photo']['tmp_name'],"../upload_images/testimonial/".$img);
	  copy("../upload_images/testimonial/".$img,"../upload_images/testimonial/thumb/".$img);
	  $Image->load("../upload_images/testimonial/thumb/".$img);
	  $Image->resize(78,81);
	  $Image->save("../upload_images/testimonial/thumb/".$img);
	  }  
  
  if($_REQUEST['id']==''){
	  $obj->query("insert into $tbl_testimonial set testimonial='$testimonial',posted_by='$posted_by',photo='$img',posted_date=now(),status=1 ");
	  $_SESSION['sess_msg']='Testimonial added sucessfully';  
	  
       }else{ 
	   $sql=" update $tbl_testimonial set testimonial='$testimonial',posted_by='$posted_by' ";
	   if($img){
	   $imageArr=$obj->query("select photo from $tbl_testimonial where id=".$_REQUEST['id']);
	   $resultImage=$obj->fetchNextObject($imageArr);
	   @unlink("../upload_images/testimonial/".$resultImage->photo);
	   @unlink("../upload_images/testimonial/thumb/".$resultImage->photo);
	    $sql.=" , photo='$img' ";
	   }
	   $sql.="  where id=".$_REQUEST['id'];
	   $obj->query($sql);
	   $_SESSION['sess_msg']='Testimonial updated sucessfully';   
        }
   header("location:testimonial-list.php");
   exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_testimonial where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}
	
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include("header.php"); ?>
   <?php include("menu.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Add/Update Testimonial</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="testimonial-list.php">View Testimonial List</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-primary">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Posted By:</label>
				<input name="posted_by" type="text" id="posted_by" size="36" value="<?php echo stripslashes($result->posted_by);?>" class='form-control' />
              </div>
              
            <div class="col-md-6">
            	<div class="form-group">
                <label>Image :</label>
				<input type="file" name="photo"  /><br/> 
				  <?php if(is_file("../upload_images/testimonial/thumb/".$result->photo)){ ?>
				  <img src="../upload_images/testimonial/thumb/<?php echo $result->photo; ?>" width="80" height="80" />
				  <?php } ?>
              </div>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Testimonial:</label>
				<textarea name="testimonial" rows="10" cols="60" class='form-control' ><?php echo stripslashes($result->testimonial); ?></textarea>
              </div>
          </div>
          </div>
          
       </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
		<input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
		</div>
		</form>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
  <div class="control-sidebar-bg"></div>
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script type="text/javascript" language="javascript">
function validate(obj)
{
if(obj.testimonial.value==''){
alert("Please enter city");
obj.city.focus();
return false;
}
}
</script>
</body>
</html>
