<?php
include("../include/config.php");
include("../include/functions.php");
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	$level_name=$obj->escapestring($_REQUEST['level_name']);
	$commission=$obj->escapestring($_REQUEST['commission']);
	$min_price=$obj->escapestring($_REQUEST['min_price']);
	$max_price=$obj->escapestring($_REQUEST['max_price']);


	if($_REQUEST['id']==''){
		$obj->query("insert into $tbl_level set level_name='$level_name',commission='$commission',min_price='$min_price',max_price='$max_price',img='$img'",$debug=-1);
		$_SESSION['sess_msg']='Level added sucessfully';
	}else{     
		$obj->query("update $tbl_level set level_name='$level_name',commission='$commission',min_price='$min_price',max_price='$max_price' where id='".$_REQUEST['id']."'");
		$_SESSION['sess_msg']='Level updated successfully';   
	}
	header("location:level-list.php");
	exit();
}
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_level where id=".$_REQUEST['id']);
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
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Reward Name</label>
					<input type="text" id="first-name-vertical" class="form-control" name="level_name" placeholder="Level Name" required data-validation-required-message="This Level Name field is required" value="<?php echo stripslashes($result->level_name);?>">	
				</div>  	                                           
			</div>
		</div>	

		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Reward Amount</label>
					<input type="text" id="first-name-vertical" class="form-control" name="level_name" placeholder="Level Name" required data-validation-required-message="This Level Name field is required" value="<?php echo stripslashes($result->level_name);?>">	
				</div>  	                                           
			</div>
		</div>	


	</div>

	<div class="row">
		<div class="col-4">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Min Price</label>
					<input type="text" id="min_price" class="form-control" name="password" placeholder="Min Price" required data-validation-required-message="This Min Price field is required" value="<?php echo stripslashes($result->min_price);?>">	
				</div>  	                                           
			</div>
		</div>	
		<div class="col-4">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Max Price</label>
					<input type="text" id="max_price" class="form-control" name="max_price" placeholder="Max Price" required data-validation-required-message="This Max Price field is required" value="<?php echo stripslashes($result->max_price);?>">		
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
