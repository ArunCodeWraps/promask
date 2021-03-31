<?php
ob_start();
session_start(); 
include("../include/config.php");
include("../include/functions.php");
validate_admin();

if($_POST['submitForm']=="yes"){
	$lottery_time_start= $obj->escapestring($_POST['lottery_time_start']);
	$lottery_time_end= $obj->escapestring($_POST['lottery_time_end']);

	$obj->query("update $tbl_admin set lottery_time_start='$lottery_time_start',lottery_time_end='$lottery_time_end' where id=".$_SESSION['sess_admin_id']);
	$_SESSION['sess_msg']='Time updated sucessfully';
}



if($_SESSION['sess_admin_id']){
	$sql=$obj->query("select * from $tbl_admin where id=".$_SESSION['sess_admin_id']);
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
      <h1>Set Time</h1>
	  <div class="box-header">
               <?php if($_SESSION['sess_msg']){ ?><h3 class="box-title"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></font></h3> <?php }?>
            </div>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="model-list.php">View Model</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
		 <form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return valid(this)">
                <input type="hidden" name="submitForm" value="yes" />
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
			  <div class="form-group">
                <label>Voting Start Time:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" type="text" name="lottery_time_start" id="lottery_time_start" value="<?php echo $result->lottery_time_start; ?>">
                </div>
              </div>
			   <div class="form-group">
                <label>Voting End Time:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" type="text" name="lottery_time_end" id="lottery_time_end" value="<?php echo $result->lottery_time_end; ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Submit"  class="submit" border="0"/>&nbsp;&nbsp;
		<input name="Reset" type="reset" id="Reset" value="Reset" class="submit" border="0" />
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

<script src="datepicker/bootstrap-datepicker.js"></script>

<script>
	$('#lottery_time_start').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd'
    });
	
	$('#lottery_time_end').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd'
    });
	
	function  valid(obj) {
	if(obj.lottery_time.value=='')	{
	alert("Please enter end time.");
	return false;
	}
if(obj.lottery_time_start.value=='')	{
	alert("Please enter start time .");
	return false;
	}
	
	else return true;
	}

</script>
</body>
</html>
