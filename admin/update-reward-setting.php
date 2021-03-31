<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();
if($_REQUEST['submitForm']=='yes'){
	$reward_point=$obj->escapestring($_POST['reward_point']);
	$point_value=$obj->escapestring($_POST['point_value']);
    $registration_point=$obj->escapestring($_POST['registration_point']);
	$purchasing_point=$obj->escapestring($_POST['purchasing_point']);
	$redeemed_limit=$obj->escapestring($_POST['redeemed_limit']);
	$referral_point=$obj->escapestring($_POST['referral_point']);
	$comment_point=$obj->escapestring($_POST['comment_point']);
	$download_coupon_point=$obj->escapestring($_POST['download_coupon_point']);

  
	$purchasing_point_status= $obj->escapestring($_POST['purchasing_point_status']);
	if (empty($purchasing_point_status)) {
    $purchasing_point_status=0;
  }else{
    $purchasing_point_status=1;
  }

  $welcome_point_status=$obj->escapestring($_POST['welcome_point_status']); 
  if (empty($welcome_point_status)) {
    $welcome_point_status=0;
  }else{
    $welcome_point_status=1;
  }
  
  $comment_status=$obj->escapestring($_POST['comment_status']); 
  if (empty($comment_status)) {
    $comment_status=0;
  }else{
    $comment_status=1;
  }
  
  $referral_point_status=$obj->escapestring($_POST['referral_point_status']); 
  if (empty($referral_point_status)) {
    $referral_point_status=0;
  }else{
    $referral_point_status=1;
  }
  
  $download_coupon_status=$obj->escapestring($_POST['download_coupon_status']); 
  if (empty($download_coupon_status)) {
    $download_coupon_status=0;
  }else{
    $download_coupon_status=1;
  }

  $obj->query("update tbl_reward_setting set reward_point='".$reward_point."' , point_value='$point_value',registration_point='$registration_point',purchasing_point='$purchasing_point',redeemed_limit='$redeemed_limit',purchasing_point_status='$purchasing_point_status',welcome_point_status='$welcome_point_status',comment_point='$comment_point',comment_status='$comment_status',referral_point='$referral_point',referral_point_status='$referral_point_status',download_coupon_point='$download_coupon_point',download_coupon_status='$download_coupon_status'  where id=1",$debug=-1); //die;
	$_SESSION['sess_msg']='Reward Setting updated successfully';   
}      

$sql=$obj->query("select * from tbl_reward_setting where id=1");
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
      <h1>Ajuste de actualización</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Punto de recompensa</label>
			       	<input name="punto de recompensa" type="number" class='form-control' value="<?php echo stripslashes($result->reward_point);?>" /> 
              </div>
              </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Valor de un punto ( cantidad en COP )</label>
				        <input name="point_value" type="text" class='form-control' value="<?php echo stripslashes($result->point_value);?>" /> 
              </div>
			    </div>
             <div class="col-md-3">
              <div class="form-group">
                <label> Puntos por Registrarse</label>
                <input name="registration_point" type="number" maxlength="3"  class='form-control' value="<?php echo stripslashes($result->registration_point);?>" /> 
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label>Puntos por cada compra</label>
                <input name="purchasing_point" type="number" maxlength="3"  class='form-control' value="<?php echo stripslashes($result->purchasing_point);?>" /> 
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label>Puntos por usuarios referidos</label>
                <input name="referral_point" type="number" maxlength="3"  class='form-control' value="<?php echo stripslashes($result->referral_point);?>" /> 
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label>Puntos por comentar</label>
                <input name="comment_point" type="number" maxlength="3"  class='form-control' value="<?php echo stripslashes($result->comment_point);?>" /> 
              </div>
          </div>
          
          <div class="col-md-3">
              <div class="form-group">
                <label>Puntos por descargas de cupones</label>
                <input name="download_coupon_point" type="number" maxlength="3"  class='form-control' value="<?php echo stripslashes($result->download_coupon_point);?>" /> 
              </div>
          </div>
          <div class="col-md-3">&nbsp;
          </div>
			  <!--<div class="col-md-3">
              <div class="form-group">
                <label>Redeemed Limit</label>
				      <input name="redeemed_limit" type="text" class='form-control' size="5" value="<?php echo stripslashes($result->redeemed_limit);?>" />
              </div>
              </div>-->
              
			  <div class="col-md-3">
                <div class="form-group" style="margin-top:30px">
                <label>Activar puntos por registro</label>
                <input type="checkbox"  name="welcome_point_status" value="1" <?php if($result->welcome_point_status==1) {?>checked<?php }?> /> 
                      </div>
                </div>
			  
              <div class="col-md-3">
              <div class="form-group" style="margin-top:30px">
                <label>Activar puntos por comprar</label>
        				<input type="checkbox"  name="purchasing_point_status" value="1" <?php if($result->purchasing_point_status==1) {?>checked<?php }?> /> 
                </div>
        	  </div>
        	  
        	  <div class="col-md-3">
                <div class="form-group" style="margin-top:30px">
                <label>Activar puntos por referidos</label>
                <input type="checkbox"  name="referral_point_status" value="1" <?php if($result->referral_point_status==1) {?>checked<?php }?> /> 
                      </div>
             </div>
             <div class="col-md-3">
                <div class="form-group" style="margin-top:30px">
                <label>Activar puntos por comentarios</label>
                <input type="checkbox"  name="comment_status" value="1" <?php if($result->comment_status==1) {?>checked<?php }?> /> 
                      </div>
             </div>
             
             <div class="col-md-3">
                <div class="form-group" style="margin-top:30px">
                <label>Activar puntos por descargar cupones</label>
                <input type="checkbox"  name="download_coupon_status" value="1" <?php if($result->download_coupon_status==1) {?>checked<?php }?> /> 
                      </div>
             </div>

                
			  
          </div>
       </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Enviar"  class="button" border="0"/>
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
