<?php
ob_start();
session_start(); 
include('../include/config.php');
include("../include/functions.php");
validate_admin();
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
      	<div class="col-md-3 listpage"><h4>Administrar noticias</h4></div>
      	<div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
      	<div class="col-md-3"><p style="text-align:right">
      		<span><input type="button" name="add" value="Add news"  class="button" onclick="location.href='news-addf.php'" /></span>	
      		</p>
      	</div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
		<form name="frm" method="post" action="news-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="testimonisl-list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width='60px'>
                  	<div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
                  </th>
                  <th style="text-align:center; width:100px">Titulo</th>
                  <th style="text-align:center; width:100px">Imagen</th>
                  <th style="text-align:center; width:500px">Descripcion</th>
                  <th style="text-align:center; width:100px">Estado</th>
				  <th style="text-align:center; width:100px">Editar</th>
				  
                </tr>
                </thead>
                <tbody>
				<?php
				$i=1;
				$sql=$obj->query("select * from $tbl_news where 1=1",$debug=-1);
				while($line=$obj->fetchNextObject($sql)){?>
                <tr style="text-align:center">
					<td style="text-align:center"><div class="squaredFour">
			            <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
			            <label for="squaredFour<?php echo $line->id;?>"></label>
			          </div></td>
					<td style="text-align:center"><?php echo stripslashes($line->title); ?></td>
					<td style="text-align:center">
						<?php if(is_file("../upload_images/news/thumb/".$line->photo)){?><img src="../upload_images/news/thumb/<?php echo  $line->photo;?>" style="width:100px; height: 100px;"/><?php } ?>
					</td>
					<td style="text-align:center"><p><?php echo substr(stripslashes($line->pdesc),0,150); ?></p></td>
					<td align="center"style="text-align:center">
					    <?php if($line->status==1){?>
			          <a href="javascript:void(0)" class="btn btn-primary" title="Activated"> <i class="fa fa-check"></i></a>
			          <?php } else{ ?>
			            <a href="javascript:void(0)" class="btn btn-primary" title="Deactivated"> <i class="fa fa-close"></i></a>
			          <?php }?></td>
			          <td style="text-align:center"><a href="news-addf.php?id=<?php echo $line->id;?>" class="btn btn-primary" title="edit"> <i class="fa fa-pencil"></i></a>
			          </td>
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
		      <input type="submit" name="Submit" value="Habilitar" class="button btn-success" onclick="return del_prompt(this.form,this.value)" />
		      <input type="submit" name="Submit" value="Inhabilitar" class="button btn-warning" onclick="return del_prompt(this.form,this.value)" />
		      <input type="submit" name="Submit" value="Borrar" class="button btn-danger" onclick="return del_prompt(this.form,this.value)" />
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
<script>
  $(function () {
    $("#testimonisl-list").DataTable();
  });
</script>
<script>
	function del_prompt(frmobj,comb)
		{
		//alert(comb);
			if(comb=='Borrar'){
				if(confirm ("Are you sure you want to delete record(s)"))
				{
					frmobj.action = "news-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
		}
		else if(comb=='Inhabilitar'){
			frmobj.action = "news-del.php";
			frmobj.what.value="Disable";
			frmobj.submit();
		}
		else if(comb=='Habilitar'){
			frmobj.action = "news-del.php";
			frmobj.what.value="Enable";
			frmobj.submit();
		}
		
	}

</script>
<script type="text/javascript">
$("#check_all").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
</body>
</html>
