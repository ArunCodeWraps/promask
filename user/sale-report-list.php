<?php
include('../include/config.php');
include("../include/functions.php");
validate_user();


$whr ="";
if($_POST['search_filter']){
    $search_filter = $_POST['search_filter'];
    if($search_filter==1){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 7 DAY)";
    }else if($search_filter==2){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    }else if($search_filter==3){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 3 MONTH)";
    }else if($search_filter==4){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 6 MONTH)";
    }else if($search_filter==5){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    }
}
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<style type="text/css">
    .orderviewdetails{
        max-width: 900px;
    }
</style>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <link rel="stylesheet" href="../colorbox/colorbox.css" />
    <script src="../colorbox/jquery.colorbox.js"></script>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Sell Report</h2>
                            <p style="margin-left: 350px; color: blue; font-weight: bold" id="msg"></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                        <section id="basic-datatable">
                        <div class="row">
                        <div class="col-12">
                        <div class="card">
                        <div class="card-header">
                        
                        <form name="sellsearchFrm" method="post" action="">
                        <div class="col-md-10 d-flex">
                            <select name="search_filter" class="form-control" style="width: 250px;">
                                <option value="">All</option>
                                <option value="1" <?PHP if($_POST['search_filter']==1){?> selected <?php } ?>>Weekly</option>
                                <option value="2" <?PHP if($_POST['search_filter']==2){?> selected <?php } ?>>Monthly</option>
                                <option value="3" <?PHP if($_POST['search_filter']==3){?> selected <?php } ?>>Quarterly</option>
                                <option value="4" <?PHP if($_POST['search_filter']==4){?> selected <?php } ?>>Half Yearly</option>
                                <option value="5" <?PHP if($_POST['search_filter']==5){?> selected <?php } ?>>Yearly</option>
                            </select>
                            <input type="submit" name="Search" class="btn btn-danger ml-2">
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                        </form>
                    
                        </div>
                        <div class="card-content">
                        <div class="card-body card-dashboard">

                        <div class="table-responsive">
                        <table class="table zero-configuration">
                        <thead>
                        <tr>
                        <th>Order Date/Time</th>
                        <th>Name/Email</th>
                        <th>Order ID</th>
                        <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $totAmt=0;
                        if($_SESSION['sess_user_type']=='user'){
                        $sql=$obj->query("select * from $tbl_order where 1=1 and user_id='".$_SESSION['sess_user_id']."' and order_status=3  $whr order by id desc",$debug=-1);
                        }else{
                        $sql=$obj->query("select * from $tbl_order where 1=1 and (user_id='".$_SESSION['sess_user_id']."' or seller_id='".$_SESSION['sess_user_id']."') and order_status=3  $whr order by id desc",$debug=-1);
                        }

                        while($line=$obj->fetchNextObject($sql)){?>
                        <tr>
                            <td class="product-image"><?php echo stripslashes($line->order_date); ?></td>
                            <td class="product-image"><?php echo ucfirst(strtolower(getField('name',$tbl_user,$line->user_id))); ?><br>
                                <?php echo getField('email',$tbl_user,$line->user_id); ?>
                            </td>
                            <td class="product-name"><?php echo stripslashes($line->order_id); ?></td>
                            <td class="product-image">$<?php echo stripslashes($line->total_amount); ?></td>

                        </tr>
                        <?php 
                        $totAmt = $totAmt + $line->total_amount;
                        $i++; }?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" style="text-align: right">Total</th>
                            <th>$<?php echo $totAmt ?></th>

                        </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </section>
                        <!-- Data list view end -->

                    </div>
                </div>
            </div>
            <!-- END: Content-->
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog orderviewdetails">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>




            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>

            <?php include("footer.php"); ?>
            <!-- <script src="app-assets/js/scripts/extensions/toastr.js"></script> -->

        </body>
        <!-- END: Body-->

        </html>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.zero-configuration').DataTable();
            })
        </script>


        <?php
        if (!empty($_SESSION['sess_msg'])) { ?>
            <script>
                toastr.success('<?php echo $_SESSION['sess_msg']; ?>', 'Success!', { "progressBar": true });
            </script>
            <?php $_SESSION['sess_msg']=''; } ?>

            <style type="text/css">
                .dt-buttons{
                    display: none;
                }    
            </style>