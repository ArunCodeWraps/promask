<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_admin();


$obj->query("update $tbl_order set new_order='1' ",$debug=-1);


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
          <div class="col-md-3"><h4>Administrar todos los pedidos</h4></div>
          <div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
          <div class="col-md-3">
            <!-- <form class="form-horizontal" action="csv_export_manage_order.php" method="post" name="upload_excel"   
            enctype="multipart/form-data">
            <div class="form-group">
              <div class="col-md-4 col-md-offset-4">
                <input type="submit" name="Export" class="btn btn-success" value="Exportar a Excel"/>
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
                      <th style="text-align:center; width:50px">SNo.</th>
                      <th style="text-align:center; width:350px">Fecha / hora del pedido</th>
                      <th style="text-align:center; width:100px">Product </th>
                      <th style="text-align:center; width:150px">Nombre / ID de usuario</th>
                      <th style="text-align:center; width:250px">Booking Date</th>
                      <th style="text-align:center; width:100px">Amount total</th>
                      <th style="text-align:center; width:100px">M??todo de pago</th>
                      <th style="text-align:center; width:100px">Estado de pago</th>
                      <th style="text-align:center; width:100px">Ver</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $whr = 'order by id desc';
                    $i=1;
                    $sql=$obj->query("select * from tbl_ticket_book_order where 1=1 $whr",$debug=-1);
                    while($line=$obj->fetchNextObject($sql)){?>
                    <tr>
                      <td style="text-align:center; width:50px"><div class="squaredFour">
                        <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" />
                        <label for="squaredFour<?php echo $line->id;?>"></label>
                      </div></td>   
                      <td style="text-align:center"><?php echo $i; ?></td>
                      <td style="text-align:center"><?php echo date('d M Y H:i',strtotime($line->cdate)); ?><br/><?php echo CalculateOrderTime($line->cdate); ?></td>
                      <td style="text-align:center"><?php echo getField('name','tbl_promotion',$line->product_id); ?></td>
                      <td style="text-align:center"><?php echo $line->name." ".$line->surname." <br/>(User Id :".stripslashes($line->user_id).") "; ?></td>

                      <td style="text-align:center"><?php echo $line->enter_date."<br>To - ".$line->departure_date; ?></td>
                      <td style="text-align:center"><?php echo "$".number_format($line->total_amount,2); ?></td>
                      <td style="text-align:center"><?php if($line->payment_method==1){ echo "Payu"; }else if($line->payment_method==2){ echo "Card"; }else if ($line->payment_method==3){ echo "Coin"; }  ?></td>
                      <td style="text-align:center"><?php if($line->payment_status==1){ echo "Paid"; }else { echo "Pending"; }  ?></td>
                      <script>
                        $(document).ready(function(){
                          $(".iframeOrder<?php echo $line->id; ?>").colorbox({iframe:true, width:"900px;", height:"800px;", frameborder:"0",scrolling:true});
                        });
                      </script>
                      <td style="text-align:center">
                        <a href="view-ticket-order-detail.php?order_id=<?php echo $line->id; ?>"  class="iframeOrder<?php echo $line->id; ?>" >
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
    frmobj.action = "order-del.php";
    frmobj.what.value="Delete";
    frmobj.submit();

  }
  else{ 
    return false;
  }
}
else if(comb=='Disable'){
  frmobj.action = "order-del.php";
  frmobj.what.value="Disable";
  frmobj.submit();
}
else if(comb=='Enable'){
  frmobj.action = "order-del.php";
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
