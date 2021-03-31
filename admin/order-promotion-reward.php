<?php
  session_start(); 
  include("../include/config.php");
  include("../include/functions.php"); 
  validate_admin();
  $obj->query("update tbl_promotional_points_order set new_order='1' ",$debug=-1);
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
        <div class="col-md-5"><h4>Lista de pedidos de productos de punto de recompensa de promoción</h4></div>
        <div class="col-md-5"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
        <div class="col-md-2">
    <!-- <form class="form-horizontal" action="csv_export_manage_order.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <input type="submit" name="Export" class="btn btn-success" value="export to excel"/>
                            </div>
                   </div>                    
            </form> -->
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
                  <th style="text-align:center">Fecha / hora del pedido</th>
                  <th  style="text-align:center">Solicitar ID</th>
                  <th  style="text-align:center">Nombre / ID de usuario</th>
                  <th style="text-align:center">nombre del producto</th>
                  <th style="text-align:center">Cantidad total</th>
                  <th style="text-align:center">Metodo de pago</th>
                  <th style="text-align:center">Estado de pago</th>
                  <th style="text-align:center; width:50px">Ver</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                 $whr = 'order by id desc';

                  
                  $i=1;
                  $sql=$obj->query("select * from tbl_promotional_points_order where 1=1 $whr",$debug=-1);
                  while($line=$obj->fetchNextObject($sql)){?>
                   <tr>
                    <td><div class="squaredFour">
			            <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
			            <label for="squaredFour<?php echo $line->id;?>"></label>
			          </div></td>   
                    <td><?php echo date('d M Y H:i',strtotime($line->order_date)); ?><br/><?php echo CalculateOrderTime($line->order_date); ?></td>
                    <td><?php echo stripslashes($line->id); ?></td>
                    <td><?php echo getUserName($line->user_id)." <br/>(User Id :".stripslashes($line->user_id).") "; ?></td>
                    <td><?php echo getField('name','tbl_point_promotion',$line->product_id); ?></td>
                    <td><?php 
                                if ($line->payment_method=='reward') {
                                    echo $amountt=$line->total_amount.' Points';
                                } else {
                                  echo $amountt='$'.$line->total_amount;
                                }
                              ?>
                                
                    </td>
                    <td><?php echo ucfirst($line->payment_method);    ?></td>
                    <td><?php if($line->payment_status==1){ echo "Paid"; }else { echo "Pending"; }  ?></td>
                    <script>
                      $(document).ready(function(){
                      $(".iframeOrder<?php echo $line->id; ?>").colorbox({iframe:true, width:"900px;", height:"800px;", frameborder:"0",scrolling:true});
                      $(".iframeAddc<?php echo $line->id; ?>").colorbox({iframe:true, width:"800px;", height:"600px;", frameborder:"0",scrolling:true});
                      $(".iframeViewc<?php echo $line->id; ?>").colorbox({iframe:true, width:"800px;", height:"600px;", frameborder:"0",scrolling:true});
                      });
                    </script>
                  <td>
                    <a href="view-promotion-reward-order-detail.php?order_id=<?php echo $line->id; ?>"  class="iframeOrder<?php echo $line->id; ?>" >
                    <img src="images/viewdetail.jpg" height="40" width="40" title="View Details"></a>
                   
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
    $("#example1").DataTable();
  });
</script>
<script>
	function del_prompt(frmobj,comb)
		{
		//alert(comb);
			if(comb=='Borrar'){
				if(confirm ("Are you sure you want to delete record(s)"))
				{
					frmobj.action = "promotion-order-reward-del.php";
					frmobj.what.value="Delete";
					frmobj.submit();
					
				}
				else{ 
				return false;
				}
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
