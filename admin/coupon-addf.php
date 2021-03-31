<?php
include('../include/config.php');
include("../include/functions.php");
validate_admin();


if($_REQUEST['submitForm']=='yes'){
$valid_for=$obj->escapestring($_POST['valid_for']);
$discount_type=$obj->escapestring($_POST['discount_type']);
$discount=$obj->escapestring($_POST['discount']);
$user_email=$obj->escapestring($_POST['user_email']);
$expire_date=$obj->escapestring($_POST['expire_date']);
$minimum_purchase=$obj->escapestring($_POST['minimum_purchase']);
$coupon_code=generateCouponCode();

if($_REQUEST['id']==''){
$obj->query("insert into $tbl_coupon set valid_for='$valid_for',discount_type='$discount_type',discount='$discount',user_email='$user_email',expire_date='$expire_date',minimum_purchase='$minimum_purchase',generate_date=now(),coupon_code='$coupon_code'",$debug=-1); //die;
$_SESSION['sess_msg']='Coupon added sucessfully';  
}else{ 
$obj->query("update $tbl_coupon set valid_for='$valid_for',discount_type='$discount_type',discount='$discount',user_email='$user_email',expire_date='$expire_date',minimum_purchase='$minimum_purchase',generate_date=now(),coupon_code='$coupon_code' where id='".$_REQUEST['id']."'");
$_SESSION['sess_msg']='Coupon updated sucessfully';   

}
header("location:coupon-list.php");
exit();
}      

if($_REQUEST['id']!=''){
	$sql=$obj->query("select * from $tbl_coupon where id=".$_REQUEST['id']);
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
<h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Coupon</h4>
</div>
<div class="card-content">
<div class="card-body">
<form name="frm" id="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
<input type="hidden" name="submitForm" value="yes" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
<div class="form-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
              <div class="controls">	
                <label for="first-name-vertical">Valid For:</label>
                <input name="valid_for"  type="radio" value="All" checked="checked" onclick="$('.usergroup').hide(); $('.imageoffer').show();"/> ALL Users&nbsp;
                    <input name="valid_for"  type="radio" value="Particular" <?php if($result->valid_for=='Particular'){ ?>checked<?php } ?> onclick="$('.usergroup').show(); $('.imageoffer').hide();"/> Particular User	
              </div>  	                                           
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
              <div class="controls">	
                <label for="first-name-vertical">Discount Type</label>
                <input name="discount_type"  type="radio" value="Percent" checked="checked"/>Percent&nbsp;
                    <input name="discount_type"  type="radio" value="Direct" <?php if($result->discount_type=='Direct'){ ?>checked<?php } ?> /> Direct
              </div>  	                                           
            </div>
        </div>
        <div class="col-6 usergroup" style="display: none;">
            <div class="form-group">
              <div class="controls">	
                <label for="first-name-vertical">User</label>
               <select name="user_email" id="user_email" class="form-control">
                      <option value="">Select</option>
                      <?php
                      $GropSql = $obj->query("select * from $tbl_user where status =1");
                      while($GroupResult = $obj->fetchNextObject($GropSql)){?>
                        <option value="<?php echo $GroupResult->email; ?>" <?php if($result->user_email==$GroupResult->email){?> selected <?php } ?>><?php echo $GroupResult->email; ?></option>
                      <?php }
                      ?>

                    </select>
              </div>  	                                           
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
              <div class="controls">	
                <label for="first-name-vertical">Discount ($ or %)</label>
                <div class="custom-file">
                    <input name="discount" type="text" id="discount" class='required form-control' size="36" value="<?php echo stripslashes($result->discount);?>" /> 
              </div>  	                                           
            </div>
        </div>
    </div>
        <div class="col-6">
            <div class="form-group">
              <div class="controls">	
                 <label>Minimum Purchase ($)</label>
                    <input name="minimum_purchase" type="text" class='form-control' id="minimum_purchase" size="36" value="<?php echo stripslashes($result->minimum_purchase);?>" /> 
              </div>  	                                           
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
              <div class="controls">	
                <label>Valid Till</label>
                    <input name="expire_date" type="text" id="expire_date" class='required form-control' size="36" value="<?php if($result->expire_date!='0000-00-00'){ echo stripslashes($result->expire_date);}?>" />
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
</body>
</html>

<script src="js/jquery.validate.min.js"></script>
  <script type="text/javascript" language="javascript">
    $(document).ready(function(){
      $("#frm").validate();
    })
  </script>

  <link rel="stylesheet" href="calender/css/jquery-ui.css">
  <script src="calender/js/jquery-ui.js"></script>
  <script>
    $(function() {
      $( "#expire_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')?>:<?php echo date('Y')+10?>',
        dateFormat: "yy-mm-dd",
      });

    });
  </script>
