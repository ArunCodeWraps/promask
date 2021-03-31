<?php
  session_start(); 
  include("../include/config.php");
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
 
  <script src="js/jquery-2.2.3.min.js"></script>
  <link rel="stylesheet" href="../colorbox/colorbox.css" />
  <script src="../colorbox/jquery.colorbox.js"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <div class="row">
        <div class="col-md-3"><h4>Manage Dispatch Orders</h4></div>
        <div class="col-md-6"><p style="text-align:center"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
        <div class="col-md-3">
    <form class="form-horizontal" action="csv_export_manage_order.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <input type="submit" name="Export" class="btn btn-success" value="export to excel"/>
                            </div>
                   </div>                    
            </form>
    </div>
      </div>
    </section>
    <div class="box box-primary" style="padding:5px 5px 15px 5px ;margin:10px 15px 0px 15px;width:auto">
    <section class="content-header">
      <form name="searchactiveorderfrm" id="searchactiveorderfrm" method="post" accept="order-active-list.php"> 
        <div class="row">
          <div class="col-md-3"><label>Customer Name</label>
            <input type="text" name="ship_name" class="form-control" value="<?php if($_POST['ship_name']!=''){ echo $_POST['ship_name']; } ?>">
          </div>
          <div class="col-md-3"><label>Order ID</label>
            <input type="text" name="order_id" class="form-control" value="<?php if($_POST['order_id']!=''){ echo $_POST['order_id']; } ?>">
          </div>
          <div class="col-md-3"><label>Mobile No.</label>
            <input type="text" name="ship_mobile" class="form-control" value="<?php if($_POST['ship_mobile']!=''){ echo $_POST['ship_mobile']; } ?>">
          </div>
          <div class="col-md-3"><label>Address.</label>
            <input type="text" name="ship_address" class="form-control" value="<?php if($_POST['ship_address']!=''){ echo $_POST['ship_address']; } ?>">
          </div>
        </div>

        <div class="row">
          <div class="col-md-3"><label>Order Date From</label>
            <input type="text" name="order_date_from" id="order_date_from" class="form-control" value="<?php if($_POST['order_date_from']!=''){ echo $_POST['order_date_from']; } ?>">
          </div>
          <div class="col-md-3"><label>To</label>
            <input type="text" name="order_date_to" id="order_date_to" class="form-control" value="<?php if($_POST['order_date_to']!=''){ echo $_POST['order_date_to']; } ?>">
          </div>
          <div class="col-md-1"><label>&nbsp;</label></div>
          <div class="col-md-2"><label>&nbsp;</label>
            <input type="submit" name="name" class="form-control" value="Search" style="background: #337ab7 none repeat scroll 0 0; border-radius: 3px; color: #fff; text-align: center;">
          </div>
          <div class="col-md-2"><label>&nbsp;</label>
            <a href="order-dispatch-list.php" class="form-control" style="background: #337ab7 none repeat scroll 0 0; border-radius: 3px; color: #fff; text-align: center;">Search All</a>
          </div>
          <div class="col-md-1"><label>&nbsp;</label></div>
        </div>
      </form>
    </section>
</div>
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
                  <th>SNo.</th>
                  <th>Order Date/Time</th>
                  <th>Order  ID</th>
                  <th>Name / Phone</th>
                  <th>Total Amount</th>
                  <th>Payment Method</th>
                  <th>Comments</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                 $whr = '';

                  if($_POST['ship_name']!=''){
                    $ship_name = $_POST['ship_name'];
                    $whr .= " and (ship_name like '%$ship_name%' or ship_lname like '%$ship_name%'";
                  }
                  if($_POST['order_id']!=''){
                    $order_id = $_POST['order_id'];
                    $whr .= " and order_id ='$order_id'";
                  }
                  if($_POST['ship_mobile']!=''){
                    $ship_mobile = $_POST['ship_mobile'];
                    $whr .= " and ship_mobile = '$ship_mobile'";
                  }
                  if($_POST['ship_address']!=''){
                    $ship_address = $_POST['ship_address'];
                    $whr .= " and (ship_flat like '%$ship_address%' or ship_flor like '%$ship_address%' or ship_house_no like '%$ship_address%' or ship_block like '%$ship_address%' or ship_sectorno like '%$ship_address%' or ship_landmark like '%$ship_address%' or ship_city like '%$ship_address%' or ship_area like '%$ship_address%' )";
                  }
                  if($_POST['order_date_from']!='' && $_POST['order_date_to']!=''){
                    $order_date_from = $_POST['order_date_from'];
                    $order_date_to = $_POST['order_date_to'];
                    $whr .= " and order_date between '$order_date_from' and '$order_date_to'";
                  }
                  $i=1;
                  $sql=$obj->query("select * from $tbl_order where 1=1 and order_status=5 $whr",$debug=-1);
                  while($line=$obj->fetchNextObject($sql)){?>
                   <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d M Y H:i',strtotime($line->order_date)); ?><br/><?php echo CalculateOrderTime($line->order_date); ?></td>
                    <td><?php echo stripslashes($line->id); ?></td>
                    <td><?php echo stripslashes($line->ship_fname)." ".stripslashes($line->ship_lname)." <br/>".stripslashes($line->ship_phone)." "; ?></td>
                    <td><?php echo $website_currency_symbol." ".number_format($line->total_amount,2); ?></td>
                    <td><?php echo stripslashes($line->payment_method);?></td>
                    <script>
                      $(document).ready(function(){
                      $(".iframeOrder<?php echo $line->id; ?>").colorbox({iframe:true, width:"900px;", height:"800px;", frameborder:"0",scrolling:true});
                      $(".iframeAddc<?php echo $line->id; ?>").colorbox({iframe:true, width:"800px;", height:"600px;", frameborder:"0",scrolling:true});
                      $(".iframeViewc<?php echo $line->id; ?>").colorbox({iframe:true, width:"800px;", height:"600px;", frameborder:"0",scrolling:true});
                      });
                    </script>
                  <td>
                    <a href="vieworder-detail.php?order_id=<?php echo $line->id; ?>"  class="iframeOrder<?php echo $line->id; ?>" >
                    <img src="images/viewdetail.jpg" height="40" width="40" title="View Details"></a>
                   
                    <img src="images/printinvoice.jpg" onclick="window.open('printInvoice.php?order_id=<?php echo $line->id; ?>')" height="30" width="30" title="Print">
                    <a href="addcommets.php?order_id=<?php echo $line->id; ?>"  class="iframeAddc<?php echo $line->id; ?>"><img src="images/add.png" border="0" title="Add Comment" width="20" height="20"  /></a> &nbsp; 
                    <a href="viewcommets.php?order_id=<?php echo $line->id; ?>"  class="iframeViewc<?php echo $line->id; ?>"><img src="images/comments.png" border="0" title="View Comment" width="20" height="20"  /></a>

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
  
  function checkall(objForm)
    {
  len = objForm.elements.length;
  var i=0;
  for( i=0 ; i<len ; i++){
    if (objForm.elements[i].type=='checkbox') 
    objForm.elements[i].checked=objForm.check_all.checked;
  }
   }
  function del_prompt(frmobj,comb)
    {
    //alert(comb);
      if(comb=='Delete'){
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

</body>
</html>
