<?php
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();
if($_REQUEST['submitForm']=='yes'){
	
	$landline=$obj->escapestring($_POST['landline']);
	$mobile=$obj->escapestring($_POST['mobile']);
	$email=$obj->escapestring($_POST['email']);
	$address=$obj->escapestring($_POST['address']);
	$regis_days=$obj->escapestring($_POST['regis_days']);
	
	$app_cat_align=$obj->escapestring($_POST['app_cat_align']);
	
	$web_popup_show_home=$obj->escapestring($_POST['web_popup_show_home']);
    
      if($_FILES['discount_image']['size']>0 && $_FILES['discount_image']['error']==''){
       
        $img=time().$_FILES['discount_image']['name'];
        move_uploaded_file($_FILES['discount_image']['tmp_name'],"../upload_images/discount_image/".$img);
        
        $obj->query("update $tbl_setting set mobile='$mobile',email='$email',landline='$landline',address='$address',regis_days='$regis_days',app_cat_align='$app_cat_align',web_popup_show_home='$web_popup_show_home',discount_image='$img' where id=1",$debug=-1); //die;
        
      }else{
          $obj->query("update $tbl_setting set mobile='$mobile',email='$email',landline='$landline',address='$address',regis_days='$regis_days',app_cat_align='$app_cat_align',web_popup_show_home='$web_popup_show_home' where id=1",$debug=-1); //die;
      } 
  
  
	//$obj->query("update $tbl_setting set mobile='$mobile',email='$email',landline='$landline',address='$address',regis_days='$regis_days',app_cat_align='$app_cat_align',web_popup_show_home='$web_popup_show_home' where id=1",$debug=-1); //die;
	$_SESSION['sess_msg']='Setting updated successfully';   
}      

$sql=$obj->query("select * from $tbl_setting where id=1");
$result=$obj->fetchNextObject($sql);
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
      <div class="row">
        <div class="col-md-3 listpage"><h4>Update Setting</h4></div>
        <div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
      </div>
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
                <label>Mobile Number</label>
				<input name="mobile" type="text" id="mobile" class='form-control' size="36" value="<?php echo stripslashes($result->mobile);?>" />
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>Telephone</label>
				<input name="landline" type="text" id="landline" class='form-control' size="36" value="<?php echo stripslashes($result->landline);?>">
              </div>
			  </div>
			  <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
				<input name="email" type="text" id="email" class='form-control' size="36" value="<?php echo stripslashes($result->email);?>" />
              </div>
              </div>
              
              
              
                            
			  <div class="col-md-12">
              <div class="form-group">
                <label>Address</label>
				<textarea name="address" id="address" rows="5" cols="30" class='form-control'><?php echo stripslashes($result->address);?></textarea>
              </div>
            </div>
          </div>
       </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Enviar"  class="button" border="0"/>&nbsp;&nbsp;
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
if(obj.city.value==''){
alert("Please enter city");
obj.city.focus();
return false;
}
}
</script>
</body>
</html>
