<?php
	include("../include/config.php");
	include("../include/functions.php"); 
	validate_admin();

  if ($_REQUEST['sid']=='') {
    header("location:student-list.php");
  }

 $student_id=$_REQUEST['sid']; 
 $_SESSION['sid']=$_REQUEST['sid'];
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
       <div class="row">
      	<div class="col-md-3 listpage"><h4>Student Semister List</h4></div>
      	<div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
      	<div class="col-md-3"><p style="text-align:right">
      		<span><input type="button" name="add" value="Add Result & Admit Card"  class="button" onclick="location.href='student-semister-addf.php?sid=<?php echo $student_id ?>'" /></span>	
      		</p>
      	</div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		<form name="frm" method="post" action="brand-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th style="text-align:center; width:7%">
                    <div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
                  </th>
				            <th style="text-align:center; width:10%">Student Name</th>
                    <th style="text-align:center; width:10%">Semister</th>
                    <th style="text-align:center; width:10%">Result</th>
                    <th style="text-align:center; width:10%">Admit Card</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$i=1;
				$sql=$obj->query("select * from tbl_student_detail where 1=1 and student_id='$student_id' order by id desc",$debug=-1);
				while($line=$obj->fetchNextObject($sql)){?>
                <tr style="text-align:center">
					<td style="text-align:center"><div class="squaredFour">
                  <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
                  <label for="squaredFour<?php echo $line->id;?>"></label>
                </div></td>

					         <td style="text-align:center"><?php echo getField('student_name','tbl_student',$student_id); ?></td>
                   <td style="text-align:center"><?php echo stripslashes($line->semister); ?></td>
                   <td style="text-align:center"><?php if(!empty($line->result)){ ?>
                    <a href="../upload_images/student/<?php echo $line->result; ?>" download>Download</a>
                    <?php  } ?></td>
                    <td style="text-align:center"><?php if(!empty($line->admit_card)){ ?>
                    <a href="../upload_images/student/<?php echo $line->admit_card; ?>" download>Download</a>
                    <?php  } ?></td>					         
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
          <!-- <div class="col-md-9"></div> -->
          <div class="col-md-12">
          <input type="hidden" name="what" value="what" />
          <input type="submit" name="Submit" value="Delete" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
          </div>
          </div>
				</form>
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
<style type="text/css">
table th{
  font-size: 12px;
}  
</style>

<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
<script>

	function del_prompt(frmobj,comb)
		{
		//alert(comb);
			if(comb=='Delete'){
				if(confirm ("Are you sure you want to delete record(s)"))
				{
					frmobj.action = "student-semister-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
		}
		else if(comb=='Disable'){
			frmobj.action = "student-del.php";
			frmobj.what.value="Disable";
			frmobj.submit();
		}
		else if(comb=='Enable'){
			frmobj.action = "student-del.php";
			frmobj.what.value="Enable";
			frmobj.submit();
		}
		
	}

  function showOnhome(id,chk){
  $.ajax({
    url:"showBannerOnHome.php",
    data:{pro_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }
  
  function showOnSlide(id,chk){
  $.ajax({
    url:"showBannerOnHome.php",
    data:{pro_slide_id:id,chk:chk},
    success:function(data){  
        //console.log(data);
      $("#msg").html("Record updated successfully").show().fadeOut('slow');
    }
    })
  }
  
  
  function myFunction (value,id) {
  var val=value;
  var id=id;
  $.ajax({
    url:"showBannerOnHome.php",
    data:{productt_id:id,value:value},
    success:function(data)
    {
      console.log(data);
    }

  })
}

  function myFunction2 (value,id) {
  var val=value;
  var id=id;
  $.ajax({
    url:"showBannerOnHome.php",
    data:{productt_slide_id:id,value:value},
    success:function(data)
    {
      console.log(data);
    }

  })
}

</script>


<script src="js/change-status.js"></script> 
</body>
</html>
