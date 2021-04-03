
<?php
include("../include/config.php");
include("../include/functions.php");
validate_admin();

if($_POST['submitForm'] == "yes") {
  $new_password=$obj->escapestring($_POST['new_password']);
  $confirm_password=$obj->escapestring($_POST['confirm_password']);

  if($new_password==$confirm_password){
    $query=$obj->query("select * from $tbl_admin where id=".$_SESSION['sess_admin_id'],$debug=-1);
    $result=$obj->fetchNextObject($query);

     $obj->query("update $tbl_admin set password='$new_password' where id=".$_SESSION['sess_admin_id']);
      $_SESSION['sess_msg']='Your password has been updated successfully !';
  }else{
    $_SESSION['sess_msg']='Both password are not same!';
  }
}
if($_SESSION['sess_admin_id']){
  $sql=$obj->query("select * from $tbl_admin where id=".$_SESSION['sess_admin_id']);
  $result=$obj->fetchNextObject($sql);
}
  
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

<?php include("header.php"); ?>
<?php include("menu.php"); ?>


<div class="app-content content">

<div class="content-wrapper">
<div class="content-body">
<p style="text-align:center; color: red;"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p>
<section id="basic-vertical-layouts " class="simple-validation">
<div class="row match-height">
<div class="col-md-6 col-12">
<div class="card">
<div class="card-header">
<h4 class="card-title">Change Password</h4>

</div>
<div class="card-content">
<div class="card-body">
   <form name="frm" id="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="form-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <div class="controls">	
                        <label for="first-name-vertical">New Password</label>
                        <input type="password" id="first-name-vertical" class="form-control" name="new_password" placeholder="New Password" required data-validation-required-message="This New Password field is required" value="<?php echo $_POST['new_password']; ?>">	
                      </div>  	                                           
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                      <div class="controls">    
                        <label for="first-name-vertical">Confirm Password</label>
                        <input type="password" id="first-name-vertical" class="form-control" name="confirm_password" placeholder="Confirm Password" required data-validation-required-message="This Confirm Password field is required" value="<?php echo $_POST['confirm_password']; ?>">  
                      </div>                                               
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                    <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<?php include("footer.php"); ?>
</body>
</html>
