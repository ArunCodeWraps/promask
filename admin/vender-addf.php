<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
 validate_admin();

  if($_REQUEST['submitForm']=='yes'){
    $vender_name=$obj->escapestring($_POST['vender_name']);
    $contact1=$obj->escapestring($_POST['contact1']);
    $contact2=$obj->escapestring($_POST['contact2']);
    $contact3=$obj->escapestring($_POST['contact3']);
    $city=$obj->escapestring($_POST['city']);
    $email=$obj->escapestring($_POST['email']);
    $address=$obj->escapestring($_POST['address']);
    $bane_name=$obj->escapestring($_POST['bane_name']);
    $account_no=$obj->escapestring($_POST['account_no']);
    $ifccode=$obj->escapestring($_POST['ifccode']);
    $ccode = rand(1000,9999);
    $code =  strtoupper(substr($vender_name,0,3)).$ccode;

    if($_REQUEST['id']==''){
      $obj->query("insert into $tbl_vender set vender_name='$vender_name',code='$code',contact1='$contact1',contact2='$contact2',contact3='$contact3',city='$city',email='$email',address='$address',bane_name='$bane_name',account_no='$account_no',ifccode='$ifccode'");
      $_SESSION['sess_msg']='Vender added successfully';  

    }else{ 
      $obj->query("update $tbl_vender set vender_name='$vender_name',contact1='$contact1',contact2='$contact2',contact3='$contact3',city='$city',email='$email',address='$address',bane_name='$bane_name',account_no='$account_no',ifccode='$ifccode' where id=".$_REQUEST['id'],$debug=-1); //exit;
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
      <h1><?php if($_REQUEST['id']==''){?> ADD <?php }else{?> UPDATE <?php }?> VENDOR</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> HOME</a></li>
        <li><a href="vender-list.php">VIEW VENDOR LIST</a></li>
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
                <label>Name</label>
				        <input type="text" name="vender_name" value="<?php echo stripslashes($result->vender_name); ?>" class="form-control">
              </div>
              </div>
               <div class="col-md-3">
               <div class="form-group">
               <label>Contact No. 1</label>
                <input type="text" name="contact1" maxlength="10" value="<?php echo stripslashes($result->contact1); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
               <label>Contact No. 2</label>
                <input type="text" name=" contact2" maxlength="10" value="<?php echo stripslashes($result-> contact2); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
               <label>Contact No. 3</label>
                <input type="text" name=" contact3" maxlength="10" value="<?php echo stripslashes($result-> contact3); ?>" class="form-control">
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
                <label>Email</label>
                <input type="text" name="email" value="<?php echo stripslashes($result->email); ?>" class="form-control">
              </div>
              </div>


             
           

              <div class="col-md-12">
              <div class="form-group">
              <label>Address</label>
              <textarea name="address" class="form-control"><?php echo stripslashes($result->address); ?></textarea>

              </div>
              </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bane_name" value="<?php echo stripslashes($result->bane_name); ?>" class="form-control">
              </div>
              </div>
               <div class="col-md-3">
               <div class="form-group">
               <label>Account No</label>
                <input type="text" name="account_no" value="<?php echo stripslashes($result->account_no); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
               <label>IFC Code</label>
                <input type="text" name="ifccode" value="<?php echo stripslashes($result->ifccode); ?>" class="form-control">
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
