<?php
ob_start();
session_start(); 
include('../include/config.php');
include("../include/functions.php");
validate_admin();
if($_SESSION['user_type']!='admin'){
	header("location:welcome-emp.php");
	exit();
}
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Top Model List</h1>
	  <div class="box-header" id="msg">
               <?php if($_SESSION['sess_msg']){ ?><h3 class="box-title"><font color="#FF0000"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></font></h3> <?php }?>
            </div>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="javascript:void(0);">Top Model</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            
            <!-- /.box-header -->
			<form name="frm" method="post" action="model-del.php" enctype="multipart/form-data">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Age</th>
                  <th>Height</th>
				  <th>Weight</th>
				  <th>Size(B/W/H)</th>
				  <th>Total Point</th>
				  <th>Image</th>
				  <th>Winner</th>
				  
                </tr>
                </thead>
                <tbody>
				<?php
				$sql=$obj->Query("select m.id,m.name,m.phone,m.dob,m.height,m.weight,m.bust,m.waist,m.hips,m.winner,l.user_id, sum(point) as tot from $tbl_like as l inner join $tbl_model as m on l.model_id=m.id where 1=1 group by l.model_id order by tot desc limit 0,20",$debug=-1);
				while($line=$obj->fetchNextObject($sql)){?>
                <tr>
					<td><?php echo ucfirst(stripslashes($line->name)); ?></td>
					<td><?php echo getField('email',$tbl_login,$line->user_id); ?></td>
					<td><?php echo stripslashes($line->phone); ?></td>
					<td><?php echo date('Y')- date('Y',strtotime($line->dob)); ?>&nbsp Years</td>
					<td><?php echo stripslashes($line->height); ?>&nbsp;CM</td>
					<td><?php echo stripslashes($line->weight); ?>&nbsp;Kg</td>
					<td><?php echo stripslashes($line->bust)." / ".stripslashes($line->waist)." / ".stripslashes($line->hips); ?></td>
					<td><?php echo getLikePoints($line->id); ?></td>
					<td>
					<?php 
					$pSql = $obj->query("select photo from $tbl_photo where model_id='".$line->id."' and main=1");
					$pResult = $obj->fetchNextObject($pSql);

					if(is_file("../upload_images/model/thumb/".$pResult->photo)){?>
					<img src="../upload_images/model/thumb/<?php echo $pResult->photo; ?>" height="60" width="100" />
					<?php 	
					}
					?>
					</td>
					<td align="center"><input type="radio" name="winner" value="<?php echo $line->id;?>" <?php if($line->winner==1){ ?>checked<?php } ?> onclick="return makeWinner(this.value,this.checked)" /></td>
                </tr>
				<?php }?>
				
                </tbody>
				
                <tfoot>
                </tfoot>
				
              </table>
            </div>

			</form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
    <script type="text/javascript">
function makeWinner(id,chk){
	msg = confirm("Are you sure you want make winner of this model");
	if(msg==true){
	$.ajax({
		url:"makeWinner.php",
		data:{id:id,chk:chk},
		success:function(data){
			//alert(data);
			$("#msg").html("Winner updated successfully").show().fadeOut("slow");
		}
		
		})
	}else{
		window.location.href="topmodel-list.php";
		return;
	}
}
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#check_all").click(function(){
	if($(this).is(":checked")){
		$(".checkall").attr("checked","checked");	
	  }else{
		$(".checkall").removeAttr("checked");
	  } 
	
	})
})
</script>
</body>
</html>
