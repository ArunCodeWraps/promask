<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();
  $social_url=$obj->escapestring($_POST['social_url']);
  $title=$obj->escapestring($_POST['title']);
  if($_REQUEST['submitForm']=='yes'){
  if($_REQUEST['id']==''){
	  $obj->query("insert into $tbl_social set title='$title',social_url='$social_url',status=1 ");
	  $_SESSION['sess_msg']='Social network link added sucessfully';  
	  
       }else{ 
	  $obj->query("update $tbl_social set social_url='$social_url' where id=".$_REQUEST['id']);
	  $_SESSION['sess_msg']='Social network link updated sucessfully';   
        }
   header("location:social-list.php");
   exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_social where id=".$_REQUEST['id']);
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
      <h1>Update Social Link</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="social-list.php">View Social Link</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Title</label>
                <?php echo stripslashes($result->title); ?>
              </div>
              <div class="form-group">
                <label>URL</label>
				<input type="text" name="social_url" value="<?php echo stripslashes($result->social_url); ?>" class="form-control">
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
if(obj.social_url.value==''){
alert("Please enter URL");
obj.social_url.focus();
return false;
}
}
</script>
</body>
</html>
