<?php
include("../include/config.php");
include("../include/functions.php");
validate_user();

if($_REQUEST['submitForm']=='yes'){

$name=$obj->escapestring($_POST['name']);
$email=$obj->escapestring($_POST['email']);

if($_SESSION['sess_user_id']!=''){
    $obj->query("update tbl_user set name='$name',email='$email' where id='".$_SESSION['sess_user_id']."'");
    $_SESSION['sess_msg']='Data updated successfully';   
}

header("location:profile-editf.php");
exit();

}

if($_SESSION['sess_user_id']!=''){
    $sql=$obj->query("select * from $tbl_user where id=".$_SESSION['sess_user_id']);
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
<h4 class="card-title">Update Profile</h4>
</div>
<div class="card-content">
<div class="card-body">
   <form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="form-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <div class="controls">	
                        <label for="first-name-vertical">Name</label>
                        <input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Name" required data-validation-required-message="This Name field is required" value="<?php echo stripslashes($result->name);?>">	
                      </div>  	                                           
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                      <div class="controls">	
                        <label for="first-name-vertical">Email</label>
                        <input type="text" id="first-name-vertical" class="form-control" name="email" placeholder="Email" required data-validation-required-message="This Name field is required" value="<?php echo stripslashes($result->email);?>">	
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
