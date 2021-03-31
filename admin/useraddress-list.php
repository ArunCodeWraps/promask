<?php
ob_start();
session_start(); 
include('../include/config.php');
include("../include/functions.php");
validate_admin();
$usr_id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include("header.php"); ?>
  <!-- Left side column. contains the logo and sidebar -->
 <?php include("menu.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!--section class="content-header">
      <h1><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Address</h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="user-list.php">View Address List</a></li>
      </ol>
    </section-->
    <!-- Content Header (Page header) -->
	<section class="content-header">
      <div class="row">
        <div class="col-md-4"><h4>Manage Address of <?php echo getField('name',$tbl_user,$_REQUEST['id'])." ".getField('surname',$tbl_user,$_REQUEST['id']); ?></h4></div>
        <div class="col-md-5"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
          <div class="col-md-3 text-right">
          <span><input type="button" name="add" value="Back User"  class="button btn-success" onclick="location.href='user-list.php'" /></span>  
         <span><input type="button" name="add" value="Add Address"  class="button btn-success" onclick="location.href='useraddress-addf.php?user_id=<?php echo $usr_id;?>'" /></span>  
          </p>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
        <form name="frm" method="post" action="user-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>
                  <div class="squaredFour">
                <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                <label for="squaredFour"></label>
                </div>
                </th>
                <th width="60%">Address</th>
                <th>Main</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody>
        <?php
		$id = $_GET['id'];
		
        $i=1;
        $sql=$obj->query("select * from $tbl_useraddress where user_id=$id",$debug=-1);
        while($line=$obj->fetchNextObject($sql)){
			$id_for_main=$line->id;
			?>
			<tr>
				<td> 
					<div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
				</td>
				<td class="padd5">
        <?php echo stripslashes($line->flat);?>
        <?php if($line->flor!=''){ echo ",".stripslashes($line->flor); }?>
        <?php if($line->house_no!=''){ echo ",".stripslashes($line->house_no); }?>
        <?php if($line->street!=''){ echo ",".stripslashes($line->block); }?>
        <?php if($line->sectorno!=''){ echo ",".stripslashes($line->sectorno); }?>
         <?php if($line->landmark!=''){ echo ",".stripslashes($line->landmark); }?>
        <?php if($line->area!=''){ echo ",".getField('area',$tbl_area,$line->area); }?>
        <?php if($line->city!=''){ echo ",".getField('city',$tbl_city,$line->city); }?>
        <?php if($line->state!=''){ echo ", (".stripslashes($line->state).")"; }?>
        </td>
				<td class="padd5">
				   <div class="form-group">
				    
      <div class="col-lg-10">
        <div class="radio">
          <label>
		 <?php  if($line->main == 1){?>
            <input type="radio" name="main" id="main<?php echo $id_for_main; ?>" value="1" checked="checked">
		 <?php }else{$user_id=$line->user_id;?>
			 <input type="radio" name="main" id="main<?php echo $id_for_main; ?>" onclick="main_info('<?php echo $id_for_main; ?>','<?php echo $user_id;?>','1');">
		 <?php }?>
          </label>
        </div>
       
      </div></div>
				</td>
				
          <td align="center">
         <label class="switch">
                  <input type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_useraddress?>">
                  <div class="slider round"></div>
                </label>

                </td>
				<td><a href="useraddress-addf.php?user_id=<?php echo $id;?>&id=<?php echo $line->id;?>" class="btn btn-primary" title="edit"> <i class="fa fa-pencil"></i></a> </td>
				
			</tr>
        <?php $i++; }?>
        
                </tbody>
        
                <tfoot>
                </tfoot>
        
              </table>
            </div>
        

      
            <!-- /.box-body -->
          </div>
     <div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-3">
        <input type="hidden" name="what" value="what" />
		<input type="hidden" name="user_id" value="<?php echo $id; ?>" />
        <input type="submit" name="Submit" value="Enable" class="button btn-success" onclick="return del_prompt(this.form,this.value)" />
        <input type="submit" name="Submit" value="Disable" class="button btn-warning" onclick="return del_prompt(this.form,this.value)" />
        <input type="submit" name="Submit" value="Delete" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
           </div></div>
        </form>
          <!-- /.box 
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




<?php include("footer.php"); ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
<script>
function main_info(id,user_id,main1)
{
	//alert(user_id);
	var id=id;
	var main1=main1;
	var user_id=user_id;
	jQuery.ajax({
	type: "POST",
	url:"main_update.php",
	dataType: 'json',
	data: {id:id,main_val:main1,user_id:user_id},
	success: function(res){
           window.location.reload();
	}
	});
}
  function del_prompt(frmobj,comb)
  {
      if(comb=='Delete'){

        if(confirm ("Are you sure you want to delete record(s)"))
        {
          frmobj.action = "user-address-del.php";

          frmobj.what.value="Delete";
		  
		  frmobj.address_id.value="<?php echo $id; ?>";

          frmobj.submit();
        }
        else{ 
        return false;
        }
    }
    else if(comb=='Disable'){

      frmobj.action = "user-address-del.php";

      frmobj.what.value="Disable";

      frmobj.submit();
    }
    else if(comb=='Enable'){

      frmobj.action = "user-address-del.php";

      frmobj.what.value="Enable";

      frmobj.submit();
    }
    
  }

</script>

<script src="js/change-status.js"></script> 
</body>
</html>
