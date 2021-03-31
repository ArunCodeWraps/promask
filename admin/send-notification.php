<?php
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
require_once("../include/pushnotification.php");
validate_admin();
$push = new Pushnotification;

if($_REQUEST['submitForm']=='yes'){

	$title=$obj->escapestring($_POST['title']);
	$message=$obj->escapestring($_POST['content']);
	$type=$obj->escapestring($_POST['type']);
	$user_id_arr=$_POST['user_id'];
	$country_id=$obj->escapestring($_POST['country_id']);
	$send_date = date('Y-m-d H:i:s',strtotime($_POST['send_date']));

if($type==1){
	$uSql = $obj->query("select * from records where is_verified=1");
	while($uResult = $obj->fetchNextObject($uSql)){

		$user_id = $uResult->id;
		$username=$uResult->firstname;
        $type='3';
        $connection_id='';
        sendNotificationUser($uid,$title,$message,$user_id,$type,$connection_id);
	}

	$_SESSION['sess_msg']="Notification Send successfully";

}else if($type==2){

	$userArr=implode(",",$user_id_arr);
	//print_r($user_id_arr); die;
	$uSql = $obj->query("select * from records where id in ($userArr)",-1); //die;
	while($uResult = $obj->fetchNextObject($uSql)){

		$user_id = $uResult->id;
	    $user_id = $uResult->id;
		$username=$uResult->firstname;
        $type='3';
        $connection_id='';
        $uid='';
        sendNotificationUser($user_id,$title,$message,$accept_user_id,$type,$connection_id);

	}
	
}else if($type==3){

		$sql=$GLOBALS['obj']->query("select * from tbl_user_device where device_type='1'",$debug=-1);

		while($line=$GLOBALS['obj']->fetchNextObject($sql)){
	        $registrationId=$line->device_token;
	        $accept_user_id='';
	        $type='3';
	        $connection_id='';
			$responseEEE = $push->ios_push($registrationId,$title,$message,$accept_user_id,$type,$connection_id); 
		
		}
}else if($type==4){

		$sql=$GLOBALS['obj']->query("select * from tbl_user_device where device_type='2'",$debug=-1);

		while($line=$GLOBALS['obj']->fetchNextObject($sql)){
	        $registrationId=$line->device_token;
	        $accept_user_id='';
	        $type='3';
	        $connection_id='';
			$responseEEE = $push->andriod_push($registrationId,$title,$message,$accept_user_id,$type,$connection_id); 
		
		}
}

$_SESSION['sess_msg']="Notification Send successfully";
//header("location:notification-list.php");
//exit();

}

?>

<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<link rel="stylesheet" href="datepicker/datepicker3.css">
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include("header.php"); ?>
		<?php include("menu.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Send Notification</h1>
				<ol class="breadcrumb">
					
				</ol>
			</section>
			<section class="content">
				<div class="box box-primary">
					
					<form name="frm" id="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
						<input type="hidden" name="submitForm" value="yes" />
						<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Tpye</label>
										<select name="type" id="type" class="required form-control select2">
											<option value="">Select Type</option>
											<option value="1">All</option>
											<option value="2">Individual</option>
											<option value="3">IOS Users</option>
											<option value="4">Android Users</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row user_idcls"  style="display: none;">
								<div class="col-md-6 ">
									<div class="form-group">
										<label>Select Users</label>
										<select name="user_id[]" id="user_id" class="form-control select2" multiple style="width: 100%">
											<option value="">Select User</option>
											<?php
											$uSql = $obj->query("select * from records where is_verified=1");
											while($uResult = $obj->fetchNextObject($uSql)){?>
												<option value="<?php echo $uResult->id; ?>"><?php echo $uResult->firstname." ".$uResult->lastname; ?> (<?php echo $uResult->email; ?>)</option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Title</label>
										<input type="text" name="title" value="" class="required form-control">
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label>Message</label>
										<textarea name="content" rows="5" id="content" cols="30" class="required form-control"></textarea>
									</div>
								</div>

							</div>
						</div>
					<div class="box-footer">
						<input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
						<input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
						<p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:14px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p>
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
<script src="js/jquery.validate.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	$(".select2").select2({
		
			});
	$(document).ready(function(){
		$("#type").change(function(){
			type = $(this).val();
			if(type==2){
				$('.user_idcls').show();
				$('#user_id').addClass("required");
			}else{
				$('.user_idcls').hide();
				$('#user_id').removeClass("required");
			}
		})

		$("#frm").validate();
	})
</script>

</body>
</html>
