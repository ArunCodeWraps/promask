<?php
  session_start(); 
  include("../include/config.php");
  include("../include/functions.php"); 
  validate_admin();

  unset($_SESSION['member_key']);

?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include("header.php"); ?>
  <!-- Left side column. contains the logo and sidebar -->
 <?php include("menu.php"); ?>
 
  <script src="js/jquery-2.2.3.min.js"></script>
  <link rel="stylesheet" href="../colorbox/colorbox.css" />
  <script src="../colorbox/jquery.colorbox.js"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <div class="row">
        <div class="col-md-8"><h4>Administrar todas las llaves</h4></div>
        
        <div class="col-md-2">
          <form class="form-horizontal" action="csv_export_keys.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                            <input type="hidden" name="exportExcel" value="1">
                                <input type="submit" name="Export" class="btn btn-success" value="Exportar"/>
                            </div>
                   </div>                    
            </form>
      </div>

        <div class="col-md-2">
          <input type="button" name="add" value="Generar llaves"  class="button" onclick="location.href='keys-addf.php'" />
      </div>

      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
    <form name="frm" method="post" action="product-del.php" enctype="multipart/form-data">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width='60px'>
                  	<div class="squaredFour">
                      <input name="check_all" type="checkbox"  id="check_all" value="check_all" />
                      <label for="check_all"></label>
                    </div>
                  </th>    
                  <th style="text-align:center">SNo.</th>
                  <th style="text-align:center">Plan</th>
                  <th style="text-align:center">Llaves</th>
                  <th style="text-align:center">Estatus </th>
                  <th style="text-align:center">nombre de usuario</th>
                  <th style="text-align:center">Fecha</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $whr = 'order by id desc';

                  
                  $i=1;
                  $sql=$obj->query("select * from tbl_membership_key where 1=1 $whr",$debug=-1);
                  while($line=$obj->fetchNextObject($sql)){?>
                   <tr>
                    <td style="text-align:center"><div class="squaredFour">
			            <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
			            <label for="squaredFour<?php echo $line->id;?>"></label>
			          </div></td>   
                    <td style="text-align:center; width:50px"><?php echo $i; ?></td>
                    <td style="text-align:center; width:200px"><?php echo getField('name','tbl_plan',$line->plan_id); ?></td>
                    <td style="text-align:center; width:200px"><?php echo $line->member_key; ?></td>
                    <td style="text-align:center; width:100px"><?php if ($line->status==0) {
                      echo "Unused";
                    } else {
                      echo "Used";
                    }
                     ?></td>
                     
                    <td style="text-align:center; width:200px"><?php 
                    $sql1=$obj->query("select user_id from tbl_order where 1=1 and order_via='$line->member_key' ",$debug=-1);
                    $resultq=$obj->fetchNextObject($sql1);
                    //print_r($resultq);
                    if(!empty($resultq)){
                        
                        $sql2=$obj->query("select * from tbl_user where 1=1 and id='$resultq->user_id' ",$debug=-1);
                        $result2=$obj->fetchNextObject($sql2);
                        echo $result2->name." ".$result2->surname."<br>".$result2->email;
                    }
                    
                     ?></td>
                     
                    <td style="text-align:center; width:100px"><?php echo date("d-m-Y",strtotime($line->cdate)); ?></td>
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
    $("#example1").DataTable({
         "aLengthMenu": [[10, 50, 100,500, -1], [10, 50,100, 500, "All"]],
         "pageLength": 10    
    });
  });
</script>
<script>
	function del_prompt(frmobj,comb)
		{
		//alert(comb);
			if(comb=='Borrar'){
				if(confirm ("Are you sure you want to delete record(s)"))
				{
					frmobj.action = "keys-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
		}
		else if(comb=='Disable'){
			frmobj.action = "keys-del.php";
			frmobj.what.value="Disable";
			frmobj.submit();
		}
		else if(comb=='Enable'){
			frmobj.action = "keys-del.php";
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
