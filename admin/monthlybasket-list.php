<?php 
ob_start(); 
session_start(); 
include( '../include/config.php'); 
include( "../include/functions.php"); 
validate_admin(); 
?>
<!DOCTYPE html>
<html>
<?php include( "head.php"); ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include( "header.php"); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include( "menu.php"); ?>

        <script src="js/jquery-2.2.3.min.js"></script>
        <link rel="stylesheet" href="../colorbox/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-3">
                        <h4>Monthly Basket</h4>
                    </div>
                    <div class="col-md-9">
                        <p style="text-align:center">
                            <?php if($_SESSION[ 'sess_msg']){ ?><span class="box-title" style="font-size:12px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> 
                            <?php }?>
                        </p>
                    </div>

                </div>
            </section>

           <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- /.box -->
                        <form name="frm" method="post" action="placeorder-del.php" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="1">
                            <div class="box">
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;">
                                                    <div class="squaredFour">
                                                        <input type="checkbox" class="checkall" id="check_all" name="check_all" value="check_all" />
                                                        <label for="squaredFour<?php echo $line->id;?>"></label>
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Number</th>
                                                <th>Address</th>
                                                <th>Active Order</th>
                                                <th>Last Order</th>
                                                 <th>Order Status</th>
                                                <th style="width: 150px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i=1;
                                        $UserArr = ""; 

                                        $CartSql=$obj->query("select * from $tbl_cart where 1=1 and cart_type=1 group by user_id",$debug=-1);
                                        while($CartResult = $obj->fetchNextObject($CartSql)){
                                            $UserArr[] = $CartResult->user_id;
                                        }

                                        if(!empty($UserArr)){
                                            $UserId = implode(',',$UserArr);
                                            $whr = " and a.id in ($UserId) ";
                                        }
                                        
                                       $Weeklydate = date('Y-m-d');
                                        $Mytodate = date('Y-m-d', strtotime('+1 month', strtotime($Weeklydate)));

                                        $sql=$obj->query("select a.id,b.id as order_id,b.ship_timing,b.order_date,b.delivered_date,b.order_status from $tbl_user as a INNER JOIN $tbl_order as b on a.id=b.user_id where 1=1 and a.status=1 and date(order_date) = '$Mytodate' $whr and b.id in (SELECT max(id) FROM tbl_order GROUP BY user_id) order by b.id desc",$debug=-1);

                                        while($line=$obj->fetchNextObject($sql)){?>
                                            <tr>
                                                <td>
                                                    <div class="squaredFour">
                                                        <input type="checkbox" class="checkall" id="squaredFour<?php echo $line->id;?>" name="ids[]" value="<?php echo $line->id;?>" <?php  if($OrderResult->order_date!=''){?> disabled <?php }?> />
                                                        <label for="squaredFour<?php echo $line->id;?>"></label>
                                                    </div>
                                                </td>
                                                      <td class="padd5">
                                                    <?php echo getField('title',$tbl_user,$line->id)." ".getField('name',$tbl_user,$line->id)." ".getField('surname',$tbl_user,$line->id);?></td>
                                                <td class="padd5">
                                                    <?php echo getField('mobile',$tbl_user,$line->id);?></td>
                                                <td class="padd5">
                                                <?php
                                                $UserSql = $obj->query("select * from $tbl_useraddress where user_id='".$line->id."'",$debug=-1);
                                                $UserResult = $obj->fetchNextObject($UserSql);
                                                ?>
                                                <?php 
                                                if($UserResult->flat!=''){ echo stripslashes($UserResult->flat); } 
                                                if($UserResult->flor!=''){ echo ", ".stripslashes($UserResult->flor); } 
                                                if($UserResult->house_no!=''){ echo ", ".stripslashes($UserResult->house_no); } 
                                                if($UserResult->street_no!=''){ echo ", ".stripslashes($UserResult->street_no); } 
                                                if($UserResult->block!=''){ echo ", ".stripslashes($UserResult->block); } 
                                                if($UserResult->sectorno!=''){ echo ", ".stripslashes($UserResult->sectorno); } 
                                                if($UserResult->landmark!=''){ echo ", ".stripslashes($UserResult->landmark); } 
                                                if($UserResult->city!=''){ echo ", ".getField('city',$tbl_city,$UserResult->city); } 
                                                if($UserResult->area!=''){ echo ", ".getField('area',$tbl_area,$UserResult->area); } 
                                                if($UserResult->state!=''){ echo ", ".stripslashes($UserResult->state); } 
                                                ?>
                                                </td>
                                                <td align="center" valign="middle" class="padd5">
                                               <?php
                                                if(!is_null($line->order_date)){
                                                    echo date('d-m-Y',strtotime($line->order_date))."</br>".$line->ship_timing;
                                                }
                                                ?>
                                                </td>
                                                <td align="center" valign="middle" class="padd5">
                                                <?php
                                               
                                               if(!is_null($line->delivered_date) && $line->delivered_date!='0000-00-00 00:00:00'){
                                                echo date('d-m-Y',strtotime($line->delivered_date))."</br>".$line->ship_timing;
                                                }
                                             
                                                ?>
                                                </td>
                                                <td align="center" valign="middle" class="padd5">
                                                <?php
                                                
                                                if($line->order_date!=''){
                                                    echo getField('order_status',$tbl_order_status,$line->order_status);
                                                   
                                                }else{
                                                    echo "Pending";
                                                   
                                                }

                                                ?>
                                                </td>
                                               
                                                <script>
                                                $(document).ready(function(){
                                                $(".iframeDetail<?php echo $line->id; ?>").colorbox({iframe:true, width:"800px;", height:"600px;", frameborder:"0",scrolling:true});
                                                 });
                                                </script>
                                                <td>
                                                    <a href="viewcartorder-detail.php?order_id=<?php echo $line->order_id;?>" class="iframeDetail<?php echo $line->id; ?> btn btn-primary" title="View Detail"> <i class="fa fa-eye"></i>
                                                    </a>
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
                            <div class="col-md-2">
                                <input type="hidden" name="what" value="what" />
                                 <input type="submit" name="Submit" value="Place Order" class="button btn-success" onclick="return del_prompt(this.form,this.value)" />
                                </div>
                                <div class="col-md-10"></div>
                                
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




        <?php include( "footer.php"); ?>

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
        $(function() {
            $("#example1").DataTable();
        });
    </script>
    <script>
        function del_prompt(frmobj, comb) {
            if (comb == 'Place Order') {

                if (confirm("Are you sure you want to Place Order(s)")) {
                    frmobj.action = "placeorder-del.php";

                    frmobj.what.value = "Place Order";

                    frmobj.submit();
                } else {
                    return false;
                }
            }
        }
    </script>
<script src="js/change-status.js"></script> 
<link rel="stylesheet" href="calender/css/jquery-ui.css">
  <script src="calender/js/jquery-ui.js"></script>
  <script>
    $(function() {
        $( "#delivery_date_from" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-10?>:<?php echo date('Y')+1?>',
        dateFormat: "yy-mm-dd",
        });

        $( "#delivery_date_to" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'<?php echo date('Y')-10?>:<?php echo date('Y')+1?>',
        // minDate: 0,
        // MaxDate: 'today',
        dateFormat: "yy-mm-dd",
        });
    });
    </script>
</body>

</html>
