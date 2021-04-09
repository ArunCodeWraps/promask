<?php
include("../include/config.php");
include("../include/functions.php");

require_once('../vendor_firebase/autoload.php');
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


validate_admin();

if($_REQUEST['submitForm']=='yes'){
	$name=$obj->escapestring($_REQUEST['name']);
	$email=$obj->escapestring($_REQUEST['email']);
	$password=$obj->escapestring($_REQUEST['password']);
	$cpassword=$obj->escapestring($_REQUEST['cpassword']);
	if($_REQUEST['id']==''){
		$obj->query("insert into $tbl_user set seller_id='0',name='$name',email='$email',password='$password',type='seller'",$debug=-1);


		  $u_id = $obj->lastInsertedId();

	      $connection_id = uniqid().rand().uniqid();
	      $serviceAccount = ServiceAccount::fromJsonFile('../firebase_config.json');
	      $firebase = (new Factory)
	          ->withServiceAccount($serviceAccount)
	          ->withDatabaseUri('https://mychat-65fa2-default-rtdb.firebaseio.com/')
	          ->create();
	         
	      $database = $firebase->getDatabase();

	      $newPost = $database
	          ->getReference('Connections/'. $connection_id)
	          ->set([
	              'connection_id' => $connection_id,
	          ]);

	      $obj->query("insert into tbl_friend_request set from_id='0',to_id='$u_id',status='1',connection_id='$connection_id'",$debug=-1);	

		  $_SESSION['sess_msg']='User added sucessfully';



	}else{     
		$obj->query("update $tbl_user set name='$name',email='$email' where id='".$_REQUEST['id']."'",$debug=-1);
		$obj->query($sql);
		$_SESSION['sess_msg']='User updated successfully';   
	}
	header("location:seller-list.php");
	exit();
}
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_user where id=".$_REQUEST['id']);
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
<section id="basic-vertical-layouts " class="simple-validation">
<div class="row match-height">
<div class="col-md-12 col-12">
<div class="card">
<div class="card-header">
<h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Seller</h4>
</div>
<div class="card-content">
<div class="card-body">
<form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
<input type="hidden" name="submitForm" value="yes" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
<div class="form-body">
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Name</label>
					<input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Name" required data-validation-required-message="This Name field is required" value="<?php echo stripslashes($result->name);?>">	
				</div>  	                                           
			</div>
		</div>	
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Email</label>
					<input type="text" id="first-name-vertical" class="form-control" name="email" placeholder="Email" required data-validation-required-message="This Email field is required" value="<?php echo stripslashes($result->email);?>">	
				</div>  	                                           
			</div>
		</div>	
	</div>
	<?php
	if($_REQUEST['id']==''){?>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Password</label>
					<input type="password" id="password" class="form-control" name="password" placeholder="Password" required data-validation-required-message="This Password field is required" value="">	
				</div>  	                                           
			</div>
		</div>	
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Confirm Password</label>
					<input type="password" id="cpassword" class="form-control" name="cpassword" placeholder="Confirm Password" required data-validation-required-message="This Confirm Password field is required" value="">		
				</div>
				<span id="cpassmessage"></span>  	                                           
			</div>
		</div>	
	</div>
<?php }?>
	<div class="row">
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
<script type="text/javascript">
	$('#cpassword').on('keyup', function () {
		if ($('#password').val() == $('#cpassword').val()) {
			$('#cpassmessage').html('Matching').css('color', 'green');
		} else 
			$('#cpassmessage').html('Not Matching').css('color', 'red');
	});
</script>
</body>
</html>
