<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php");
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	$r_days=$obj->escapestring($_REQUEST['r_days']);
	$amount=$obj->escapestring($_REQUEST['amount']);
	$reward_name=$obj->escapestring($_REQUEST['reward_name']);

	if($_FILES['cimage']['size']>0 && $_FILES['cimage']['error']==''){
		$Image=new SimpleImage();
		$temp = explode(".", $_FILES["cimage"]["name"]);
		$img = round(microtime(true)) . '.' . end($temp);

		move_uploaded_file($_FILES['cimage']['tmp_name'],"../upload_image/reward/".$img);
		copy("../upload_image/reward/".$img,"../upload_image/reward/thumb/".$img);
		$Image->load("../upload_image/reward/thumb/".$img);
		$Image->resize(120,120);
		$Image->save("../upload_image/reward/thumb/".$img);
	}

	if($_REQUEST['id']==''){
		$obj->query("insert into $tbl_reward set r_days='$r_days',amount='$amount',reward_name='$reward_name',img='$img'",$debug=-1);
		$_SESSION['sess_msg']='Reward added sucessfully';
	}else{     
		$sql = "update $tbl_reward set r_days='$r_days',amount='$amount',reward_name='$reward_name'";
		if($img){
			$imageArr=$obj->query("select img from tbl_reward where id=".$_REQUEST['id']);
			$resultImage=$obj->fetchNextObject($imageArr);
			@unlink("../upload_image/reward/".$resultImage->img);
			@unlink("../upload_image/reward/thumb/".$resultImage->img);
			$sql.=" , img='$img' ";
		}
		$sql.=" where id='".$_REQUEST['id']."'";
		$obj->query($sql);
		$_SESSION['sess_msg']='Reward updated successfully';   
	}
	header("location:reward-list.php");
	exit();
}
if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_reward where id=".$_REQUEST['id']);
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
<h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Reward</h4>
</div>
<div class="card-content">
<div class="card-body">
	<form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
		<div class="form-body">
	
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<div class="controls">	
							<label for="first-name-vertical">Days</label>
							<input type="text" id="first-name-vertical" class="form-control" name="r_days" placeholder="Days" value="<?php echo stripslashes($result->r_days);?>" required>	
						</div>  	                                           
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<div class="controls">	
							<label for="first-name-vertical">Price</label>
							<input type="text" id="amount" class="form-control" name="amount" placeholder="Max Price" required data-validation-required-message="This Amount field is required" value="<?php echo stripslashes($result->amount);?>">
						</div> 	                                           
					</div>
				</div>
				</div>
				<div class="row">	
				<div class="col-4">
					<div class="form-group">
						<div class="controls">	
							<label for="first-name-vertical">Reward Name</label>
							<input type="text" id="first-name-vertical" class="form-control" name="reward_name" placeholder="Reward Name" required data-validation-required-message="This Reward Name field is required" value="<?php echo stripslashes($result->reward_name);?>">	
						</div>  	                                           
					</div>
				</div>	
				<div class="col-4">
					<div class="form-group">
						<div class="controls">	
							<label for="first-name-vertical">Image</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="cimage" <?php if(empty($result->id)){ echo 'required data-validation-required-message="This Image field is required"'; } ?> >
								<label class="custom-file-label">Choose file</label>

							</div>	
							<?php if(is_file("../upload_image/reward/".$result->img)){ ?>
								<img src="../upload_image/reward/<?php echo $result->img; ?>" style="width:100px" /><?php } ?>
							</div>  	                                           
						</div>
					</div>
				</div>
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
