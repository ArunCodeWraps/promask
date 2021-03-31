<?php
//session_start();
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
 validate_admin();
 
    

 
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from tbl_popup_msg where id=".$_REQUEST['id']);
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
      <h1> Popup Notification Enquiry Details</h1>
      
    </section>
    <section class="content">
      <div class="box box-primary">
		<form name="customerfrm" id="customerfrm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
           <div class="col-md-6">
              <div class="form-group">
                <label>Nombre - </label>
                <p> <?php echo $result->name; ?></p>
              </div>
            </div>
             
            
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Email - </label>
                <p> <?php echo $result->email; ?></p>
                 <!--<input type="text" name="company" class="form-control" value="<?php echo $result->company ?>" required /> -->
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label>Móvil - </label>
                <p> <?php echo $result->mobile; ?></p>
              <!--<input type="text" name="number" class="form-control" value="<?php echo $result->number ?>" required />-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Dirección - </label>
                <p> <?php echo $result->address; ?></p>
              <!--<input type="email" name="email_id" class="form-control"  value="<?php echo $result->email_id; ?>" required>-->
                            </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            

            
            <?php 
            
                $qanswer=json_decode($result->answer);
                
                foreach($qanswer as $key => $value){
            ?>
                
             <div class="col-md-12">
              <div class="form-group">
                <label>Q<?php  echo ($key+1).": ".$value->ques; ?></label>
                <p> <?php   echo $value->ans; ?></p>
              </div>
            </div>
                
            
            <?php } ?>
            
            
            
            

  		</div>
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
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#customerfrm").validate();
})
</script>
<link rel="stylesheet" href="calender/css/jquery-ui.css">
  <script src="calender/js/jquery-ui.js"></script>
  <script>
    $(function() {
        $( "#dob" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-80?>:<?php echo date('Y')-10?>',
        dateFormat: "yy-mm-dd",
        });
        $( "#doa" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-80?>:<?php echo date('Y')-10?>',
        dateFormat: "yy-mm-dd",
        });
    });
    </script>
</body>
</html>
