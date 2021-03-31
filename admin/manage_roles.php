<?php
include("../include/config.php");
include("../include/functions.php"); 
include("../include/simpleimage.php");
validate_admin();
if($_REQUEST['roles']!=''){
  $roles=implode(",",$_REQUEST['roles']);  
}

if($_REQUEST['submitForm']=='yes'){
  $obj->query("update $tbl_admin set roles='$roles' where  id='".$_REQUEST['id']."' ");
  $_SESSION['sess_msg']='Roles updated successfully';
  header("location:admin-list.php");
  exit();
}      


if($_REQUEST['id']!=''){
  $sql=$obj->query("select * from $tbl_admin where id=".$_REQUEST['id']);
  $result=$obj->fetchNextObject($sql);
}   $empRolesArr='';
if($result->roles!=''){
  $empRoles=$result->roles; 
  $empRolesArr=explode(",",$empRoles);  
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
        <h1>Manage Roles for <?php echo getField('emp_name',$tbl_admin,$_REQUEST['id'])." ".getField('emp_surname',$tbl_admin,$_REQUEST['id']); ?></h1>
        <ol class="breadcrumb">
          <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="admin-list.php">Back</a></li>
        </ol>
      </section>
      <section class="content">
        <div class="box box-default">
          <form name="frm" method="POST" enctype="multipart/form-data" action="" onsubmit="return validate(this)">
            <input type="hidden" name="submitForm" value="yes" />
            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Admin Setting</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="1" <?php if($empRolesArr!='' && in_array(1,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Banner</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="2" <?php if($empRolesArr!='' && in_array(2,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage FAQ</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="3"  <?php if($empRolesArr!='' && in_array(3,$empRolesArr)){?>checked<?php } ?>/>
                    <label>Manage Social links</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="4" <?php if($empRolesArr!='' && in_array(4,$empRolesArr)){?>checked<?php } ?> />
                    <label>Update Setting</label>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="5" <?php if($empRolesArr!='' && in_array(5,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Keys</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="6" <?php if($empRolesArr!='' && in_array(6,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage User Chating</label>
                  </div>
                </div>
              </div>
              <hr>




              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Plans</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="7" <?php if($empRolesArr!='' && in_array(7,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Plan</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Products</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="8" <?php if($empRolesArr!='' && in_array(8,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Catagory</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="9" <?php if($empRolesArr!='' && in_array(9,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Product</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="10" <?php if($empRolesArr!='' && in_array(10,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Comment</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage User</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="11" <?php if($empRolesArr!='' && in_array(11,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage User</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Enquiry</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="12" <?php if($empRolesArr!='' && in_array(12,$empRolesArr)){?>checked<?php } ?> />
                    <label>Enquiry List</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="13" <?php if($empRolesArr!='' && in_array(13,$empRolesArr)){?>checked<?php } ?> />
                    <label>Affliate List</label>
                  </div>
                </div>
              </div>
              <hr>



              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage CMS</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="14" <?php if($empRolesArr!='' && in_array(14,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage 1 Box</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="15" <?php if($empRolesArr!='' && in_array(15,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage 2 Box</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="16" <?php if($empRolesArr!='' && in_array(16,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage 4 Box</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="17" <?php if($empRolesArr!='' && in_array(17,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Pages</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Newsletter</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="18" <?php if($empRolesArr!='' && in_array(18,$empRolesArr)){?>checked<?php } ?> />
                    <label>Newsletter Subscription</label>
                  </div>
                </div>
              
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="19" <?php if($empRolesArr!='' && in_array(19,$empRolesArr)){?>checked<?php } ?> />
                    <label>Newsletter Templates</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="20" <?php if($empRolesArr!='' && in_array(20,$empRolesArr)){?>checked<?php } ?> />
                    <label>Send Newsletter</label>
                  </div>
                </div>
              </div>
              <hr>



              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Notification</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="21" <?php if($empRolesArr!='' && in_array(21,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Notification</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Order</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="22" <?php if($empRolesArr!='' && in_array(22,$empRolesArr)){?>checked<?php } ?> />
                    <label>Order Management</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Reward Point</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="23" <?php if($empRolesArr!='' && in_array(23,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Setting</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="24" <?php if($empRolesArr!='' && in_array(24,$empRolesArr)){?>checked<?php } ?> />
                    <label>Unapproved Reward Points</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="25" <?php if($empRolesArr!='' && in_array(25,$empRolesArr)){?>checked<?php } ?> />
                    <label>Reward Points Transaction</label>
                  </div>
                </div>
              </div>
              <hr>


              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Promotional Product</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="26" <?php if($empRolesArr!='' && in_array(26,$empRolesArr)){?>checked<?php } ?> />
                    <label>Promotional Product</label>
                  </div>
                </div>
              </div>
              <hr>

               <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Reward Points Product</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="27" <?php if($empRolesArr!='' && in_array(27,$empRolesArr)){?>checked<?php } ?> />
                    <label>Reward Points Product</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Promotion Product Orders</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="28" <?php if($empRolesArr!='' && in_array(28,$empRolesArr)){?>checked<?php } ?> />
                    <label>Promotion Product Orders</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="29" <?php if($empRolesArr!='' && in_array(29,$empRolesArr)){?>checked<?php } ?> />
                    <label>Promotion Notification Orders</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="30" <?php if($empRolesArr!='' && in_array(30,$empRolesArr)){?>checked<?php } ?> />
                    <label>Reward Product Orders</label>
                  </div>
                </div>
              </div>
              <hr>





              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Downloaded Coupon</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="31" <?php if($empRolesArr!='' && in_array(31,$empRolesArr)){?>checked<?php } ?> />
                    <label>Downloaded Coupon list</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage News</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="32" <?php if($empRolesArr!='' && in_array(32,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage News</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Feedback</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="33" <?php if($empRolesArr!='' && in_array(33,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Feedback</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Liked Product</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="34" <?php if($empRolesArr!='' && in_array(34,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Liked Product</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Activate User Account</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="35" <?php if($empRolesArr!='' && in_array(35,$empRolesArr)){?>checked<?php } ?> />
                    <label>Activate Account</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-md-12">
                  <h4 style="color: #3c8dbc">Manage Credit card</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="36" <?php if($empRolesArr!='' && in_array(36,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage Card</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="37" <?php if($empRolesArr!='' && in_array(37,$empRolesArr)){?>checked<?php } ?> />
                    <label>Card Assign User</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input  type="checkbox" name="roles[]" value="38" <?php if($empRolesArr!='' && in_array(38,$empRolesArr)){?>checked<?php } ?> />
                    <label>Manage User Card</label>
                  </div>
                </div>
              </div>
              <hr>


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

</body>
</html>
<style type="text/css">
hr {
    margin-top: 1px !important;
    margin-bottom: 10px !important;
    border: 0;
    border-top: 1px solid #eee;
}  
</style>