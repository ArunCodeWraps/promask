<?php
include('../include/config.php');
include("../include/functions.php");
validate_user();
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
                            <h2 class="content-header-title float-left mb-0">Order List</h2>
                            <p style="margin-left: 350px; color: blue; font-weight: bold" id="msg"></p>
                        </div>
   
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">
                  <form name="frm" method="post" action="order-del.php" enctype="multipart/form-data">  
                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order Date/Time</th>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Method of payment</th>
                                    <th>Name/Email</th>
                                    <th>Status</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              $j=1;
                              if($_SESSION['sess_user_type']=='user'){
                                $sql=$obj->query("select * from $tbl_order where 1=1 and user_id='".$_SESSION['sess_user_id']."' order by id desc",$debug=-1);
                              }else{
                                $sql=$obj->query("select * from $tbl_order where 1=1 and (user_id='".$_SESSION['sess_user_id']."' or seller_id='".$_SESSION['sess_user_id']."') order by id desc",$debug=-1);
                              }
                              
                              while($line=$obj->fetchNextObject($sql)){?>
                                <tr>
                                    <td><?php echo $j++; ?></td>
                                    <td class="product-image"><?php echo stripslashes($line->order_date); ?></td>
                                    <td class="product-name"><?php echo stripslashes($line->order_id); ?></td>
                                    <td class="product-image">$<?php echo stripslashes($line->total_amount); ?></td>
                                    <td class="product-image"><?php echo stripslashes($line->payment_method); ?></td>
                                    <td class="product-image"><?php echo ucfirst(strtolower(getField('name',$tbl_user,$line->user_id))); ?><br>
                                        <?php echo getField('email',$tbl_user,$line->user_id); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($line->order_status==1){
                                            echo "New";
                                        }else if($line->order_status==2){
                                            echo "Processing";
                                        }else if($line->order_status==3){
                                            echo "Delivered";
                                        }else if($line->order_status==4){echo "Cancelled";
                                        } 
                                        ?>
                                    </td>
                                    <td class="product-action">
                                    
                                     <a href="javascript:void(0)" class="btn btn-primary" title="View Details" onclick="viewOrder(<?php echo $line->id ?>)">
                                    <i class="fa fa-eye"></i></a>                    
                                    </td>
                                </tr>
                                <?php }?>
                                
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <!-- DataTable ends -->
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

<
<script>
    function order_status(id,status){
          $.ajax({
            url:"ajax/UpdateOrderStatus.php",
            data:{order_id:id,status:status},
            beforeSend:function(){
            },
            success:function(data){
                $("#msg").html("Record updated successfully").show().fadeOut('slow');
           }
         });
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

    function viewOrder(id){
    $.ajax({
            url:"ajax/viewOrderDetails.php",
            data:{order_id:id},
            beforeSend:function(){
            },
            success:function(data){
                $(".modal-body").html(data);
                $("#myModal").modal('show');
           }
         });
}
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