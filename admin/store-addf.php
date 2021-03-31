<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();

  if($_REQUEST['submitForm']=='yes'){
    $vender_name=mysql_real_escape_string($_POST['vender_name']);
    $code=mysql_real_escape_string($_POST['code']);
    $country=mysql_real_escape_string($_POST['country']);
    $state=mysql_real_escape_string($_POST['state']);
    $city=mysql_real_escape_string($_POST['city']);
    $area=mysql_real_escape_string($_POST['area']);
    $address=mysql_real_escape_string($_POST['address']);
    $zipcode=mysql_real_escape_string($_POST['zipcode']);
    $contact_person=mysql_real_escape_string($_POST['contact_person']);
    $contact_email=mysql_real_escape_string($_POST['contact_email']);
    $contact_phone=mysql_real_escape_string($_POST['contact_phone']);

    if($_REQUEST['id']==''){
      $obj->query("insert into $tbl_store set vender_name='$vender_name',code='$code',country='$country',state='$state',city='$city',area='$area',address='$address',zipcode='$zipcode',contact_person='$contact_person',contact_email='$contact_email',contact_phone='$contact_phone',status=1 ");
      $_SESSION['sess_msg']='Vender added successfully';  

    }else{ 
      $obj->query("update $tbl_store set vender_name='$vender_name',code='$code',country='$country',state='$state',city='$city',area='$area',address='$address',zipcode='$zipcode',contact_person='$contact_person',contact_email='$contact_email',contact_phone='$contact_phone',status=1 where id=".$_REQUEST['id'],$debug=-1); //exit;
      $_SESSION['sess_msg']='Vender updated successfully';   
    }
    
    header("location:vender-list.php");
    exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_vender where id=".$_REQUEST['id']);
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
      <h1><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Store</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="store-list.php">View Store List</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
		<form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
		<input type="hidden" name="submitForm" value="yes" />
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
        <div class="box-body">
	      <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Name</label>
				        <input type="text" name="vender_name" value="<?php echo stripslashes($result->vender_name); ?>" class="form-control">
              </div>
               <div class="form-group">
               <label>Country</label>
                <select name="country" id="country" class="form-control">
                  <option value="">Select Country</option>
                  <?php
                  $conSql = $obj->query("select id,country from $tbl_country where status=1");
                  while($ConResult = $obj->fetchNextObject($conSql)){?>
                    <option value="<?php echo $ConResult->id; ?>" <?php if($result->country==$ConResult->id){?> selected <?php }?>><?php echo $ConResult->country; ?></option>
                  <?php }?>
                </select>
               
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                 <label>Code</label>
                <input type="text" name="code" value="<?php echo stripslashes($result->code); ?>" class="form-control">
              </div>
               <div class="form-group">
                <label>State</label>
                <input type="text" name="state" value="<?php echo stripslashes($result->state); ?>" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="<?php echo stripslashes($result->city); ?>" class="form-control">
              </div>
               
            </div>
          <div class="col-md-6">
              <div class="form-group">
                <label>Area</label>
                  <input type="text" name="area" value="<?php echo stripslashes($result->area); ?>" class="form-control">
              </div>
</div>
            

              <div class="col-md-12">
              <div class="form-group">
              <label>Address</label>
              <textarea name="address" class="form-control"><?php echo stripslashes($result->address); ?></textarea>

              </div>
              </div>
            <div class="col-md-6">
              
               <div class="form-group">
                 <label>Zipcode</label>
                <input type="text" name="zipcode" maxlength="6" value="<?php echo stripslashes($result->zipcode); ?>" class="form-control">
              </div>
              <div class="form-group">
                 <label>Contact Person</label>
                <input type="text" name="contact_person" value="<?php echo stripslashes($result->contact_person); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Contact Email</label>
                <input type="text" name="contact_email" value="<?php echo stripslashes($result->contact_email); ?>" class="form-control">
              </div>
               <div class="form-group">
               <label>Contact Phone</label>
                <input type="text" name="contact_phone" maxlength="10" value="<?php echo stripslashes($result->contact_phone); ?>" class="form-control">
              </div>
            </div>

          </div>
       </div>
		<div class="box-footer">
		<input type="submit" name="submit" value="Submit"  class="button" border="0"/>&nbsp;&nbsp;
		<input name="Reset" type="reset" id="Reset" value="Reset" class="button" border="0" />
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
